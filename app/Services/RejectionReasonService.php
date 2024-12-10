<?php

namespace App\Services;

use App\Models\RejectionReason;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

readonly class RejectionReasonService
{
    // list all Rejection Reasons function
    public function list()
    {
        $rejections = RejectionReason::all();
        return $rejections;
    }

    // list all Rejection Reasons for Select List function
    public function listForSelect()
    {
        $rejections = RejectionReason::join('unit_translations', 'rejections.id', 'unit_translations.unit_id')
            ->select('rejections.id as unit_id', 'unit_translations.name as unit_name')
            ->pluck('unit_name', 'unit_id')->toArray();
        return $rejections;
    }

    // get Rejection Reason by ID function
    public function getById($id)
    {
        $rejection = RejectionReason::find($id);

        return $rejection;
    }

    // list all Rejection Reasons function AJAX
    public function listAjax($ajaxData)
    {
        $data = RejectionReason::select('*');

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
            ->addColumn('ar_name', function (RejectionReason $rejection) {
                return html_entity_decode($rejection->translate('ar')->name);
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'ar_name'])
            ->make(true);
    }

    // Store new Rejection Reason
    public function create($data)
    {
        DB::beginTransaction();

        $rejection = new RejectionReason();

        $rejection->save();

        $rejectionTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $rejectionTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $rejection->translation()->createMany($rejectionTranslations);

        DB::commit();

        return $rejection;
    }

    // Update Rejection Reason
    public function update(RejectionReason $rejection, $data)
    {
        DB::beginTransaction();

        $rejection->translation()->delete();

        $rejectionTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $rejectionTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $rejection->translation()->createMany($rejectionTranslations);

        DB::commit();

        return $rejection;
    }

    // Delete Rejection Reason
    public function delete(RejectionReason $rejection)
    {
        $rejectionCitiesCount = $rejection->cities->count();

        if ($rejectionCitiesCount > 0) {
            return false;
        }

        return $rejection->delete();
    }
}
