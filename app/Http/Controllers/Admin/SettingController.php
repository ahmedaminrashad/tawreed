<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateSettingRequest;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        private readonly SettingService $settingService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = $this->settingService->list();

        if ($request->ajax()) {
            $data['columns']    = $request->columns;
            $data['order']      = $request->order[0]['column'];
            $data['orderBy']    = $data['columns'][$data['order']]["name"];
            $data['orderDir']   = $request->order[0]['dir'];

            return $this->settingService->listAjax($data);
        }

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        return view('admin.settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        $pageTitle = 'Edit Setting';

        $pageAction = 'Edit';

        $formTitle = 'Edit Setting';

        return view('admin.settings.edit', compact('setting', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $data = $request->validated();

        $setting = $this->settingService->update($setting, $data);

        return redirect()->route('admin.settings.show', ['setting' => $setting])->with('success', 'Setting updated successfully');
    }
}
