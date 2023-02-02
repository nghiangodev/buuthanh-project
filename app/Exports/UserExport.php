<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\{Database\Query\Builder};
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class UserExport implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings, WithEvents
{
	use Exportable;

	private $filters;

	public function __construct($filters)
	{
		$this->filters = $filters;
	}

	/**
	 * @return User|\Illuminate\Database\Eloquent\Builder|Builder
	 */
	public function query()
	{
		$filters    = $this->filters;
		$isNotEmpty = collect($filters)->filter()->isNotEmpty();

		$users = User::with('roles')->where('username', '<>', 'admin')->whereKeyNot(auth()->id());

		if ($isNotEmpty) {
			// note: filter role trước, nếu để sau filters sẽ tìm role bị sai

			if (isset($filters['role_id']) && filled($filters['role_id'])) {
				$roleIds = $filters['role_id'];
				$users->role($roleIds);
			}

			$users->filters($filters);
		}

		$users = $users->orderBy('id', 'desc');

		return $users;
	}

	/**
	 * @param User $user
	 *
	 * @return array
	 */
	public function map($user): array
	{
		return [
			$user->username,
			$user->name,
			$user->phone,
			$user->email,
			optional($user->roles)[0]['name'],
			strip_tags($user->state_text),
			optional($user->last_login_at)->format('d-m-Y H:i:s'),
		];
	}

	public function headings(): array
	{
		$user = new User();

		return [
			$user->label('username'),
			$user->label('full_name'),
			$user->label('phone'),
			$user->label('email'),
			$user->label('role'),
			$user->label('state'),
			$user->label('last_login_at'),
		];
	}

	/**
	 * @return array
	 */
	public function registerEvents(): array
	{
		return [
			AfterSheet::class => static function (AfterSheet $event) {
				$headerStyle = $event->sheet->getDelegate()->getStyle('A1:H1');
				$headerStyle->getFont()->setBold(true);

				$headerStyle->applyFromArray([
					'font' => [
						'size' => 16,
					],
				]);
			},
		];
	}
}
