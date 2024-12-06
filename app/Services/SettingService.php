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
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
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
}
