<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuAuthorizationStoreRequest;
use App\Http\Requests\MenuAuthorizationUpdateRequest;
use App\Http\Resources\MenuAuthorizationCollection;
use App\Http\Resources\MenuAuthorizationResource;
use App\Models\MenuAuthorization;
use Illuminate\Http\Request;

class MenuAuthorizationController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\MenuAuthorizationCollection
     */
    public function index(Request $request)
    {
        $menuAuthorizations = MenuAuthorization::with('privilege', 'menu');

        return new MenuAuthorizationCollection($menuAuthorizations);
    }

    /**
     * @param \App\Http\Requests\MenuAuthorizationStoreRequest $request
     * @return \App\Http\Resources\MenuAuthorizationResource
     */
    public function store(MenuAuthorizationStoreRequest $request)
    {
        $menuAuthorization = MenuAuthorization::create($request->validated());

        return new MenuAuthorizationResource($menuAuthorization->load('privilege', 'menu'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuAuthorization $menuAuthorization
     * @return \App\Http\Resources\MenuAuthorizationResource
     */
    public function show(Request $request, MenuAuthorization $menuAuthorization)
    {
        return new MenuAuthorizationResource($menuAuthorization);
    }

    /**
     * @param \App\Http\Requests\MenuAuthorizationUpdateRequest $request
     * @param \App\Models\MenuAuthorization $menuAuthorization
     * @return \App\Http\Resources\MenuAuthorizationResource
     */
    public function update(MenuAuthorizationUpdateRequest $request, MenuAuthorization $menuAuthorization)
    {
        $menuAuthorization->update($request->validated());

        return new MenuAuthorizationResource($menuAuthorization->load('privilege', 'menu'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MenuAuthorization $menuAuthorization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MenuAuthorization $menuAuthorization)
    {
        $menuAuthorization->delete();

        return response()->noContent();
    }
}
