<?php

namespace App\Exports;

use App\Models\ActivityLogger;
use App\Models\User;
use Illuminate\{Database\Query\Builder};
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ActivityLogExport implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings, WithEvents
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

		$logs = ActivityLogger::query()->with('causer');

		if ($isNotEmpty) {
			$logs->andFilterWhere(['description', 'like', $this->filters['description']])->dateBetween([
				$this->filters['from_date'],
				$this->filters['to_date'],
			]);
		}

		$logs = $logs->orderBy('id', 'desc');

		return $logs;
	}

	/**
	 * @param ActivityLogger $log
	 *
	 * @return array
	 */
	public function map($log): array
	{
		return [
			optional($log->created_at)->format('d-m-Y H:i:s'),
			optional($log->causer)->username,
			$log->description,
		];
	}

	public function headings(): array
	{
		return [
			__('Date'),
			__('Caused by'),
			__('Description'),
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
