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

    // list all Countries for Select List function
    public function listForSelect()
    {
        $countries = Country::join('country_translations', 'countries.id', 'country_translations.country_id')
            ->select('countries.id as country_id', 'country_translations.name as country_name')
            ->pluck('country_name', 'country_id')->toArray();
        return $countries;
    }

    // list all Countries Codes for Select List function
    public function listCountryCodeForSelect()
    {
        $countries = Country::join('country_translations', 'countries.id', 'country_translations.country_id')
            ->select('countries.id as country_id', DB::raw("CONCAT(countries.country_code, ' - ' , country_translations.name) AS country"))
            ->pluck('country', 'country_id')->toArray();
        return $countries;
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
            ->rawColumns(['action', 'ar_name', 'vat'])
            ->make(true);
    }
    
    // get Country by ID function
    public function getById($id)
    {
        $country = Country::find($id);

        return $country;
    }

    // Store new Country
    public function create($data)
    {
        DB::beginTransaction();

        $country = new Country();

        $country->country_code = $data['country_code'];
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
            'country_code' => $data['country_code'],
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

    // List Country Cities
    public function cities($country_id)
    {
        $country = $this->getById($country_id);

        if (!$country) {
            return false;
        }

        $cities = $country->cities_list();

        return $cities;
    }
}
