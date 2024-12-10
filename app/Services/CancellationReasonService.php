<?php

namespace App\Services;

use App\Models\CancellationReason;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

readonly class CancellationReasonService
{
    // list all Cancellation Reasons function
    public function list()
    {
        $cancellations = CancellationReason::all();
        return $cancellations;
    }

    // list all Cancellation Reasons for Select List function
    public function listForSelect()
    {
        $cancellations = CancellationReason::join('unit_translations', 'cancellations.id', 'unit_translations.unit_id')
            ->select('cancellations.id as unit_id', 'unit_translations.name as unit_name')
            ->pluck('unit_name', 'unit_id')->toArray();
        return $cancellations;
    }

    // get Cancellation Reason by ID function
    public function getById($id)
    {
        $cancellation = CancellationReason::find($id);

        return $cancellation;
    }

    // list all Cancellation Reasons function AJAX
    public function listAjax($ajaxData)
    {
        $data = CancellationReason::select('*');

        return DataTables::of($data)
            ->filter(function ($query) use ($ajaxData) {
                if ($ajaxData['search']['value']) {
                    $query->whereHas('translations', function ($query) use ($ajaxData) {
                        $search = $ajaxData['search']['value'];
                        $query->where('name', 'like', '%' . $search . '%');
                    });
                }
            }, true)
            ->addIndexColumn()
            ->addColumn('ar_name', function (CancellationReason $cancellation) {
                return html_entity_decode($cancellation->translate('ar')->name);
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'ar_name'])
            ->make(true);
    }

    // Store new Cancellation Reason
    public function create($data)
    {
        DB::beginTransaction();

        $cancellation = new CancellationReason();

        $cancellation->save();

        $cancellationTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $cancellationTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $cancellation->translation()->createMany($cancellationTranslations);

        DB::commit();

        return $cancellation;
    }

    // Update Cancellation Reason
    public function update(CancellationReason $cancellation, $data)
    {
        DB::beginTransaction();

        $cancellation->translation()->delete();

        $cancellationTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $cancellationTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $cancellation->translation()->createMany($cancellationTranslations);

        DB::commit();

        return $cancellation;
    }

    // Delete Cancellation Reason
    public function delete(CancellationReason $cancellation)
    {
        $cancellationCitiesCount = $cancellation->cities->count();

        if ($cancellationCitiesCount > 0) {
            return false;
        }

        return $cancellation->delete();
    }
}
