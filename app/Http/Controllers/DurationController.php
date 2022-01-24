<?php

namespace App\Http\Controllers;

use App\Http\Requests\DurationStoreRequest;
use App\Http\Requests\DurationUpdateRequest;
use App\Http\Resources\DurationCollection;
use App\Http\Resources\DurationResource;
use App\Models\Duration;
use Illuminate\Http\Request;

class DurationController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DurationCollection
     */
    public function index(Request $request)
    {
        $durations = Duration::all();

        return new DurationCollection($durations);
    }

    /**
     * @param \App\Http\Requests\DurationStoreRequest $request
     * @return \App\Http\Resources\DurationResource
     */
    public function store(DurationStoreRequest $request)
    {
        $duration = Duration::create($request->validated());

        return new DurationResource($duration);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Duration $duration
     * @return \App\Http\Resources\DurationResource
     */
    public function show(Request $request, Duration $duration)
    {
        return new DurationResource($duration);
    }

    /**
     * @param \App\Http\Requests\DurationUpdateRequest $request
     * @param \App\Models\Duration $duration
     * @return \App\Http\Resources\DurationResource
     */
    public function update(DurationUpdateRequest $request, Duration $duration)
    {
        $duration->update($request->validated());

        return new DurationResource($duration);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Duration $duration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Duration $duration)
    {
        $duration->delete();

        return response()->noContent();
    }
}
