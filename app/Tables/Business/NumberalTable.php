<?php

namespace App\Tables\Business;

use App\Models\Numberal;
use Cloudteam\BaseCore\Tables\DataTable;
use Cloudteam\BaseCore\Utils\HtmlAction;

class NumberalTable extends DataTable
{
    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function getData(): array
    {
        $this->column = $this->getSortColumn();
        $numberals    = $this->getModels();
        $dataArray    = [];
        $modelName    = (new Numberal)->classLabel(true);

        [$canEditNumberal, $canDeleteNumberal, $canPrintNumberal] = cans(['edit_numberal', 'delete_numberal', 'print_numberal']);

        /** @var Numberal[] $numberals */
        foreach ($numberals as $key => $numberal) {
            $htmlAction = $this->generateButton($modelName, $numberal, [$canEditNumberal, $canDeleteNumberal]);

            $dataArray[] = [
                //'<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand"><input type="checkbox" value="'.$numberal->id.'"><span></span></label>',
                ++$key + $this->start,
                $numberal->name,
                $numberal->customer->phone,
                $numberal->customer->address,
                date('d-m-Y', strtotime($numberal->customer->dob)),

                $htmlAction,
            ];
        }

        return $dataArray;
    }

    public function getSortColumn(): string
    {
        $column  = $this->column;
        $columns = ['numberals.id', 'numberals.name',];

        return $columns[$column];
    }

    /**
     * @return Numberal[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModels()
    {
        $numberals = Numberal::query();

        $this->totalFilteredRecords = $this->totalRecords = $numberals->count();

        $dob = ! empty($this->filters['dob']) ? date('Y-m-d', strtotime($this->filters['dob'])) : '';

        if ($dob) {
            $numberals->whereHas('customer', function ($q) use ($dob) {
                $q->where('dob', 'like', "%$dob%");
            });
        }

        if ($this->isFilterNotEmpty) {
            $numberals->filters($this->filters);

            $this->totalFilteredRecords = $numberals->count();
        }

        return $numberals->limit($this->length)->offset($this->start)
                         ->orderBy($this->column, $this->direction)->get();
    }

    private function generateButton(string $modelName, Numberal $numberal, array $permissions): string
    {
        [$canEditNumberal, $canDeleteNumberal] = $permissions;

        $btnPrintNumberal = '
        <a href="' . route('numberals.export_excel',
                ['id' => $numberal]) . '" class="btn-action-view btn-success btn-export-excel" target="_blank"  title="in" id="btn_view_online"><i class="far fa-file-excel"></i></a>';

        $buttonDelete = '';

        $buttonEdit = HtmlAction::generateButtonEdit($numberal->getEditLink());
        if ($canEditNumberal) {
            //$buttonChangeState = $numberal->generateButtonChangeStateActive($modelName);
        }

        if ($canDeleteNumberal) {
            $buttonDelete = $numberal->generateButtonDelete($modelName);
        }

        //$buttonView = HtmlAction::generateButtonView($numberal->getViewLink());

        return $btnPrintNumberal . $buttonEdit . $buttonDelete;
    }
}
