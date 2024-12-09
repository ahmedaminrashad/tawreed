<?php

namespace App\Services;

use App\Models\ActivityClassification;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

readonly class ActivityClassificationService
{
    // list all Activity Classifications function
    public function list()
    {
        $workCategoryClassifications = ActivityClassification::all();
        return $workCategoryClassifications;
    }

    // list all Activity Classifications for Select List function
    public function listForSelect()
    {
        $workCategoryClassifications = ActivityClassification::join('workCategoryClassification_translations', 'workCategoryClassifications.id', 'workCategoryClassification_translations.workCategoryClassification_id')
            ->select('workCategoryClassifications.id as workCategoryClassification_id', 'workCategoryClassification_translations.name as workCategoryClassification_name')
            ->pluck('workCategoryClassification_name', 'workCategoryClassification_id')->toArray();
        return $workCategoryClassifications;
    }

    // get Activity Classification by ID function
    public function getById($id)
    {
        $activityClassification = ActivityClassification::find($id);

        return $activityClassification;
    }

    // list all Activity Classifications function AJAX
    public function listAjax($ajaxData)
    {
        $data = ActivityClassification::select('*');

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
            ->addColumn('ar_name', function (ActivityClassification $activityClassification) {
                return html_entity_decode($activityClassification->translate('ar')->name);
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'ar_name'])
            ->make(true);
    }

    // Store new Activity Classification
    public function create($data)
    {
        DB::beginTransaction();

        $activityClassification = new ActivityClassification();

        $activityClassification->save();

        $activityClassificationTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $activityClassificationTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $activityClassification->translation()->createMany($activityClassificationTranslations);

        DB::commit();

        return $activityClassification;
    }

    // Update Activity Classification
    public function update(ActivityClassification $activityClassification, $data)
    {
        DB::beginTransaction();

        $activityClassification->translation()->delete();

        $activityClassificationTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $activityClassificationTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $activityClassification->translation()->createMany($activityClassificationTranslations);

        DB::commit();

        return $activityClassification;
    }

    // Delete Activity Classification
    public function delete(ActivityClassification $activityClassification)
    {
        $workCategoryClassificationCitiesCount = $activityClassification->cities->count();

        if ($workCategoryClassificationCitiesCount > 0) {
            return false;
        }

        return $activityClassification->delete();
    }
}
