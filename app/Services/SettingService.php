<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

readonly class SettingService
{
    // list all Settings function
    public function list()
    {
        $settings = Setting::all();
        return $settings;
    }

    // list all Settings function AJAX
    public function listAjax($ajaxData)
    {
        $data = Setting::select('*')->orderBy($ajaxData['orderBy'], $ajaxData['orderDir']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('key', function (Setting $setting) {
                $result = '';
                if ($setting->key == 'commission') {
                    $result = 'Commission';
                } elseif ($setting->key == 'email') {
                    $result = 'Email';
                } elseif (str_contains($setting->key, 'link')) {
                    $result = ucfirst(str_replace("_link", "", $setting->key));
                } elseif ($setting->key == 'phone') {
                    $result = 'Phone';
                } elseif ($setting->key == 'vat') {
                    $result = 'VAT';
                } elseif ($setting->key == 'review') {
                    $result = 'Review';
                }
                return $result;
            })
            ->addColumn('value', function (Setting $setting) {
                if ($setting->key == 'commission' || $setting->key == 'vat') {
                    return $setting->value . ' %';
                } elseif (str_contains($setting->key, 'link')) {
                    return sprintf(
                        '<a href="%s" target="blanked">%s</a>',
                        $setting->value,
                        $setting->value
                    );
                } elseif ($setting->key == 'email') {
                    return sprintf(
                        '<a href="mailto::%s">%s</a>',
                        $setting->value,
                        $setting->value
                    );
                } elseif ($setting->key == 'phone') {
                    return sprintf(
                        '<a href="tel:%s">%s</a>',
                        $setting->value,
                        $setting->value
                    );
                } elseif ($setting->key == 'review') {
                    if ($setting->value) {
                        return sprintf(
                            '<div class="form-check"><input class="form-check-input" type="checkbox" disabled checked><label class="form-check-label">Yes</label></div>'
                        );
                    } else {
                        return sprintf(
                            '<div class="form-check"><input class="form-check-input" type="checkbox" disabled><label class="form-check-label">No</label></div>'
                        );
                    }
                }
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'value', 'key'])
            ->make(true);
    }

    // Update Setting
    public function update(Setting $setting, $data)
    {
        DB::beginTransaction();

        $setting->update([
            'value' => $data['value']
        ]);

        DB::commit();

        return $setting;
    }

    // get Setting by key function
    public function getByKey($key)
    {
        $setting = Setting::where('key', $key)->first();

        return $setting;
    }
}
