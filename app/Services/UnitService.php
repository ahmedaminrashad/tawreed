<?php

namespace App\Services;

use App\Models\MeasurementUnit;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

readonly class UnitService
{
    // list all Measurement Units function
    public function list()
    {
        $units = MeasurementUnit::all();
        return $units;
    }

    // list all Measurement Units for Select List function
    public function listForSelect()
    {
        $units = MeasurementUnit::join('unit_translations', 'units.id', 'unit_translations.unit_id')
            ->select('units.id as unit_id', 'unit_translations.name as unit_name')
            ->pluck('unit_name', 'unit_id')->toArray();
        return $units;
    }

    // get Measurement Unit by ID function
    public function getById($id)
    {
        $unit = MeasurementUnit::find($id);

        return $unit;
    }

    // list all Measurement Units function AJAX
    public function listAjax($ajaxData)
    {
        $data = MeasurementUnit::select('*');

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
            ->addColumn('ar_name', function (MeasurementUnit $unit) {
                return html_entity_decode($unit->translate('ar')->name);
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'ar_name'])
            ->make(true);
    }

    // Store new MeasurementUnit
    public function create($data)
    {
        DB::beginTransaction();

        $unit = new MeasurementUnit();

        $unit->save();

        $unitTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $unitTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $unit->translation()->createMany($unitTranslations);

        DB::commit();

        return $unit;
    }

    // Update MeasurementUnit
    public function update(MeasurementUnit $unit, $data)
    {
        DB::beginTransaction();

        $unit->translation()->delete();

        $unitTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $unitTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $unit->translation()->createMany($unitTranslations);

        DB::commit();

        return $unit;
    }

    // Delete MeasurementUnit
    public function delete(MeasurementUnit $unit)
    {
        $unitCitiesCount = $unit->cities->count();

        if ($unitCitiesCount > 0) {
            return false;
        }

        return $unit->delete();
    }
}
