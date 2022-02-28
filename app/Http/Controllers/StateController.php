<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateStoreRequest;
use App\Http\Requests\StateUpdateRequest;
use App\Http\Resources\StateCollection;
use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\StateCollection
     */
    public function index(Request $request)
    {
        $states = State::latest()->get();

        return new StateCollection($states);
    }

    /**
     * @param \App\Http\Requests\StateStoreRequest $request
     * @return \App\Http\Resources\StateResource
     */
    public function store(StateStoreRequest $request)
    {
        $state = State::create($request->validated());

        return new StateResource($state);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\State $state
     * @return \App\Http\Resources\StateResource
     */
    public function show(Request $request, State $state)
    {
        return new StateResource($state);
    }

    /**
     * @param \App\Http\Requests\StateUpdateRequest $request
     * @param \App\Models\State $state
     * @return \App\Http\Resources\StateResource
     */
    public function update(StateUpdateRequest $request, State $state)
    {
        $state->update($request->validated());

        return new StateResource($state);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, State $state)
    {
        $state->delete();

        return response()->noContent();
    }
}
