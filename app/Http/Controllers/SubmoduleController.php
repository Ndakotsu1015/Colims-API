<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmoduleStoreRequest;
use App\Http\Requests\SubmoduleUpdateRequest;
use App\Http\Resources\SubmoduleCollection;
use App\Http\Resources\SubmoduleResource;
use App\Models\Submodule;
use Illuminate\Http\Request;

class SubmoduleController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\SubmoduleCollection
     */
    public function index(Request $request)
    {
        $submodules = Submodule::with('module')->get();

        return new SubmoduleCollection($submodules);
    }

    /**
     * @param \App\Http\Requests\SubmoduleStoreRequest $request
     * @return \App\Http\Resources\SubmoduleResource
     */
    public function store(SubmoduleStoreRequest $request)
    {
        $submodule = Submodule::create($request->validated());

        return new SubmoduleResource($submodule->load('module'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Submodule $submodule
     * @return \App\Http\Resources\SubmoduleResource
     */
    public function show(Request $request, Submodule $submodule)
    {
        return new SubmoduleResource($submodule);
    }

    /**
     * @param \App\Http\Requests\SubmoduleUpdateRequest $request
     * @param \App\Models\Submodule $submodule
     * @return \App\Http\Resources\SubmoduleResource
     */
    public function update(SubmoduleUpdateRequest $request, Submodule $submodule)
    {
        $submodule->update($request->validated());

        return new SubmoduleResource($submodule->load('module'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Submodule $submodule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Submodule $submodule)
    {
        $submodule->delete();

        return response()->noContent();
    }
}
