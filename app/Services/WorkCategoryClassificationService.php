<?php

namespace App\Services;

use App\Models\WorkCategoryClassification;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

readonly class WorkCategoryClassificationService
{
    // list all Work Category Classifications function
    public function list()
    {
        $workCategoryClassifications = WorkCategoryClassification::all();
        return $workCategoryClassifications;
    }

    // list all Work Category Classifications for Select List function
    public function listForSelect($limit = null)
    {
        $workCategoryClassifications = WorkCategoryClassification::join(
            'classification_translations',
            'classifications.id',
            'classification_translations.classification_id'
        )
            ->select('classifications.id as classification_id', 'classification_translations.name as classification_name');
        if ($limit) {
            $workCategoryClassifications = $workCategoryClassifications->limit($limit);
        }
        return $workCategoryClassifications->pluck('classification_name', 'classification_id')->toArray();
    }

    // get Work Category Classification by ID function
    public function getById($id)
    {
        $workCategoryClassification = WorkCategoryClassification::find($id);

        return $workCategoryClassification;
    }

    // list all Work Category Classifications function AJAX
    public function listAjax($ajaxData)
    {
        $data = WorkCategoryClassification::select('*');

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
            ->addColumn('ar_name', function (WorkCategoryClassification $workCategoryClassification) {
                return html_entity_decode($workCategoryClassification->translate('ar')->name);
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'ar_name'])
            ->make(true);
    }

    // Store new Work Category Classification
    public function create($data)
    {
        DB::beginTransaction();

        $workCategoryClassification = new WorkCategoryClassification();

        $workCategoryClassification->save();

        $workCategoryClassificationTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $workCategoryClassificationTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $workCategoryClassification->translation()->createMany($workCategoryClassificationTranslations);

        DB::commit();

        return $workCategoryClassification;
    }

    // Update Work Category Classification
    public function update(WorkCategoryClassification $workCategoryClassification, $data)
    {
        DB::beginTransaction();

        $workCategoryClassification->translation()->delete();

        $workCategoryClassificationTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $workCategoryClassificationTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $workCategoryClassification->translation()->createMany($workCategoryClassificationTranslations);

        DB::commit();

        return $workCategoryClassification;
    }

    // Delete Work Category Classification
    public function delete(WorkCategoryClassification $workCategoryClassification)
    {
        $workCategoryClassificationCitiesCount = $workCategoryClassification->cities->count();

        if ($workCategoryClassificationCitiesCount > 0) {
            return false;
        }

        return $workCategoryClassification->delete();
    }
}
