<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\{Contracts\View\View, Database\Query\Builder};
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class NumberalExport implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;

    private $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        return view('backend.modules.business.numberals.export_excel.form_export', [
            'invoiceDatas' => $this->filters,
        ]);

    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class => static function (AfterSheet $event) {
                $headerStyle = $event->sheet->getDelegate()->getStyle('A1:J1');

                $headerStyle->applyFromArray([
                    'font' => [
                        'size' => 16,
                    ],
                ]);
            },
        ];
    }
}
