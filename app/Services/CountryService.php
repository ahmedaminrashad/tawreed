<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

readonly class CountryService
{
    // list all Countries function
    public function list()
    {
        $countries = Country::all();
        return $countries;
    }

    // get Country by ID function
    public function getById($id)
    {
        $country = Country::find($id);

        return $country;
    }

    // list all Countries function AJAX
    public function listAjax($ajaxData)
    {
        $data = Country::select('*');

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
            ->addColumn('ar_name', function (Country $country) {
                return html_entity_decode($country->translate('ar')->name);
            })
            ->addColumn('vat', function (Country $country) {
                return html_entity_decode($country->vat . '%');
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'en_name'])
            ->make(true);
    }

    // Store new Country
    public function create($data)
    {
        DB::beginTransaction();

        $country = new Country();

        $country->vat = $data['vat'];

        $country->save();

        $countryTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $countryTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $country->translation()->createMany($countryTranslations);

        DB::commit();

        return $country;
    }

    // Update Country
    public function update(Country $country, $data)
    {
        DB::beginTransaction();

        $country->update([
            'vat' => $data['vat'],
        ]);

        $country->translation()->delete();

        $countryTranslations = [];

        foreach (config('langs') as $locale => $name) {
            $countryTranslations[] = [
                'locale' => $locale,
                'name' => $data[$locale . '_name'],
            ];
        }

        $country->translation()->createMany($countryTranslations);

        DB::commit();

        return $country;
    }

    // Delete Country
    public function delete(Country $country)
    {
        $countryCitiesCount = $country->cities->count();

        if ($countryCitiesCount > 0) {
            return false;
        }

        return $country->delete();
    }
}
