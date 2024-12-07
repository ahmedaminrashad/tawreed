<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

readonly class CityService
{
    // list all Cities function
    public function list()
    {
        $cities = City::all();
        return $cities;
    }

    // get City by ID function
    public function getById($id)
    {
        $city = City::find($id);

        return $city;
    }

    // list all Cities function AJAX
    public function listAjax($ajaxData)
    {
        $data = City::select('*');

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
            ->addColumn('ar_name', function (City $city) {
                return html_entity_decode($city->translate('ar')->name);
            })
            ->addColumn('country_name', function (City $city) {
                return html_entity_decode($city->country->translate('ar')->name);
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Store new City
    public function create($data)
    {
        DB::beginTransaction();

        $city = new City();

        $city->country_id = $data['country_id'];

        $city->save();

        $cityTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $cityTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $city->translation()->createMany($cityTranslations);

        DB::commit();

        return $city;
    }

    // Update City
    public function update(City $city, $data)
    {
        DB::beginTransaction();

        $city->update([
            'country_id' => $data['country_id'],
        ]);

        $city->translation()->delete();

        $cityTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $cityTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $city->translation()->createMany($cityTranslations);

        DB::commit();

        return $city;
    }

    // Delete City
    public function delete(City $city)
    {
        // $cityCitiesCount = $city->cities->count();

        // if ($cityCitiesCount > 0) {
        //     return false;
        // }

        return $city->delete();
    }
}
