<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyTypeStoreRequest;
use App\Http\Requests\PropertyTypeUpdateRequest;
use App\Http\Resources\PropertyTypeCollection;
use App\Http\Resources\PropertyTypeResource;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\PropertyTypeCollection
     */
    public function index(Request $request)
    {
        $propertyTypes = PropertyType::latest()->get();

        return new PropertyTypeCollection($propertyTypes);
    }

    /**
     * @param \App\Http\Requests\PropertyTypeStoreRequest $request
     * @return \App\Http\Resources\PropertyTypeResource
     */
    public function store(PropertyTypeStoreRequest $request)
    {
        $propertyType = PropertyType::create($request->validated());

        return new PropertyTypeResource($propertyType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PropertyType $propertyType
     * @return \App\Http\Resources\PropertyTypeResource
     */
    public function show(Request $request, PropertyType $propertyType)
    {
        return new PropertyTypeResource($propertyType);
    }

    /**
     * @param \App\Http\Requests\PropertyTypeUpdateRequest $request
     * @param \App\Models\PropertyType $propertyType
     * @return \App\Http\Resources\PropertyTypeResource
     */
    public function update(PropertyTypeUpdateRequest $request, PropertyType $propertyType)
    {
        $propertyType->update($request->validated());

        return new PropertyTypeResource($propertyType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PropertyType $propertyType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PropertyType $propertyType)
    {
        $propertyType->delete();

        return response()->noContent();
    }
}
