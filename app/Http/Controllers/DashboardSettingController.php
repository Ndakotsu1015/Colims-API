<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardSettingStoreRequest;
use App\Http\Requests\DashboardSettingUpdateRequest;
use App\Http\Resources\DashboardSettingCollection;
use App\Http\Resources\DashboardSettingResource;
use App\Models\DashboardSetting;
use Illuminate\Http\Request;

class DashboardSettingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DashboardSettingCollection
     */
    public function index(Request $request)
    {
        $dashboardSettings = DashboardSetting::with('chart', 'module', 'chartType', 'chartCategory');

        return new DashboardSettingCollection($dashboardSettings);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DashboardSettingCollection
     */
    public function contract(Request $request)
    {
        // $dashboardSettings = DashboardSetting::all();
        $dashboardSettings = DashboardSetting::where(['sub_module_id'=> 1,'is_active'=>true])->orderBy('orderby','asc')->get();

        return new DashboardSettingCollection($dashboardSettings);
    }

    /**
     * @param \App\Http\Requests\DashboardSettingStoreRequest $request
     * @return \App\Http\Resources\DashboardSettingResource
     */
    public function store(DashboardSettingStoreRequest $request)
    {
        $dashboardSetting = DashboardSetting::create($request->validated());

        return new DashboardSettingResource($dashboardSetting->load('chart', 'module', 'chartType', 'chartCategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DashboardSetting $dashboardSetting
     * @return \App\Http\Resources\DashboardSettingResource
     */
    public function show(Request $request, DashboardSetting $dashboardSetting)
    {
        return new DashboardSettingResource($dashboardSetting);
    }

    /**
     * @param \App\Http\Requests\DashboardSettingUpdateRequest $request
     * @param \App\Models\DashboardSetting $dashboardSetting
     * @return \App\Http\Resources\DashboardSettingResource
     */
    public function update(DashboardSettingUpdateRequest $request, DashboardSetting $dashboardSetting)
    {
        $dashboardSetting->update($request->validated());

        return new DashboardSettingResource($dashboardSetting->load('chart', 'module', 'chartType', 'chartCategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DashboardSetting $dashboardSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DashboardSetting $dashboardSetting)
    {
        $dashboardSetting->delete();

        return response()->noContent();
    }
}
