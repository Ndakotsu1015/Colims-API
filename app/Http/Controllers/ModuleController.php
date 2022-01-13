<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleStoreRequest;
use App\Http\Requests\ModuleUpdateRequest;
use App\Http\Resources\ModuleCollection;
use App\Http\Resources\ModuleResource;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ModuleCollection
     */
    public function index(Request $request)
    {
        $modules = Module::all();

        return new ModuleCollection($modules);
    }

    /**
     * @param \App\Http\Requests\ModuleStoreRequest $request
     * @return \App\Http\Resources\ModuleResource
     */
    public function store(ModuleStoreRequest $request)
    {
        $module = Module::create($request->validated());

        return new ModuleResource($module);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Module $module
     * @return \App\Http\Resources\ModuleResource
     */
    public function show(Request $request, Module $module)
    {
        return new ModuleResource($module);
    }

    /**
     * @param \App\Http\Requests\ModuleUpdateRequest $request
     * @param \App\Models\Module $module
     * @return \App\Http\Resources\ModuleResource
     */
    public function update(ModuleUpdateRequest $request, Module $module)
    {
        $module->update($request->validated());

        return new ModuleResource($module);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Module $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Module $module)
    {
        $module->delete();

        return response()->noContent();
    }
}
