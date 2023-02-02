<?php

namespace App\Http\Controllers\Modules\Backend\Business;

use App\Exports\NumberalExport;
use App\Exports\NumberalPdfExport;
use App\Http\Actions\ChangeModelState;
use App\Http\Controllers\Controller;
use App\Http\Services\NumberalService;
use App\Models\Customer;
use App\Models\ItemCat;
use App\Models\Numberal;
use App\Models\StarResolution;
use App\Tables\Business\NumberalTable;
use Cloudteam\BaseCore\Tables\TableFacade;
use Cloudteam\BaseCore\Utils\ModelFilter;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class NumberalsController extends Controller
{
    /**
     * Tên dùng để phân quyền
     * @var string
     */
    protected string $name = 'numberal';

    protected $service;

    public function __construct(NumberalService $numberalService)
    {
        parent::__construct();

        $this->middleware(['rolepermission:edit_user'], ['only' => ['changeState']]);

        $this->service = $numberalService;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $numberal = new Numberal;

        return view('backend.modules.business.numberals.index', [
            'numberal'      => $numberal,
            'headerConfigs' => [
                'model'     => $numberal,
                'caption'   => '',
                'createUrl' => route('numberals.create'),
                'buttons'   => [],
            ],
        ]);
    }

    public function table(): string
    {
        return (new TableFacade(new NumberalTable()))->getDataTable();
    }

    public function create(): View
    {
        return view('backend.modules.business.numberals.create', [
            'numberal' => new Numberal,
            'action'   => route('numberals.store', [], false),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return RedirectResponse|JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            \DB::beginTransaction();

            $datas = $request->all();

            $this->service->store($datas);

            \DB::commit();

            return $this->redirectResponse([
                'message'      => __('Data created successfully'),
                'redirect_url' => route('numberals.index'),
            ], route('numberals.index'));
        } catch (\Exception $e) {
            \DB::rollBack();

            return $this->errorResponse($e);
        }
    }

    public function show(Numberal $numberal): View
    {
        return view('backend.modules.business.numberals.show', [
            'numberal' => $numberal,
        ]);
    }

    public function edit(Numberal $numberal): View
    {
        $itemCats = ItemCat::where('numberal_id', $numberal->id)->get();

        return view('backend.modules.business.numberals.edit', [
            'numberal' => $numberal,
            'itemCats' => $itemCats,
            'method'   => 'put',
            'action'   => route('numberals.update', $numberal, false),
        ]);
    }

    /**
     * @param Request $request
     * @param Numberal $numberal
     *
     * @return RedirectResponse|JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(Request $request, Numberal $numberal)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            \DB::beginTransaction();

            $datas = $request->all();

            $this->service->update($datas, $numberal);

            \DB::commit();

            return $this->redirectResponse([
                'message'      => __('Data edited successfully'),
                'redirect_url' => route('numberals.index'),
            ], route('numberals.index'));
        } catch (\Exception $e) {
            \DB::rollBack();

            return $this->errorResponse($e);
        }
    }

    public function destroy(Numberal $numberal): JsonResponse
    {
        try {
            $numberal->delete();

            return $this->asJson([
                'message' => __('Data deleted successfully'),
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function destroys(): JsonResponse
    {
        try {
            $ids = \request()->get('ids');
            Numberal::destroy($ids);

            return $this->asJson([
                'message' => __('Data deleted successfully'),
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function numberals(): JsonResponse
    {
        $modelFilter = new ModelFilter(Numberal::query());

        $numberals = $modelFilter->filter()->selectRaw('id, name');

        $totalCount = $numberals->count();
        $numberals  = $modelFilter->getData($numberals);

        return $this->asJson([
            'total_count' => $totalCount,
            'items'       => $numberals->toArray(),
        ]);
    }

    public function starResolutions(): JsonResponse
    {
        $modelFilter = new ModelFilter(StarResolution::query());

        $StarResolution = $modelFilter->filter()->selectRaw('id, name');

        $totalCount     = $StarResolution->count();
        $StarResolution = $modelFilter->getData($StarResolution);

        return $this->asJson([
            'total_count' => $totalCount,
            'items'       => $StarResolution->toArray(),
        ]);
    }

    public function exportExcel(Request $request)
    {
        $numberal = Numberal::find($request->all()['id']);

        $pdfFileName = "sớ_cúng_sao_00{$numberal->id}.pdf";

        $filePdf = NumberalPdfExport::makePdf($numberal, 'backend.modules.business.numberals.export_excel.form_export', $pdfFileName);
        dd($filePdf);
        return \Response::make(base64_decode($filePdf), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $pdfFileName . '"',
        ]);
    }

    public function changeState(Request $request, ChangeModelState $action, Numberal $numberal): JsonResponse
    {
        $state = $request->post('state');

        $result = $action->execute($numberal, $state);

        if ($result) {
            return $this->asJson([
                'message' => __('Data edited successfully'),
            ]);
        }

        return $this->asJson([
            'message' => __('Data edited unsuccessfully'),
        ]);
    }
}
