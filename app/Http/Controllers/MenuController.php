<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuStoreRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Http\Resources\MenuCollection;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\MenuCollection
     */
    public function index(Request $request)
    {
        $menus = Menu::with('parentMenu', 'module')->get();

        return new MenuCollection($menus);
    }

    /**
     * @param \App\Http\Requests\MenuStoreRequest $request
     * @return \App\Http\Resources\MenuResource
     */
    public function store(MenuStoreRequest $request)
    {
        $menu = Menu::create($request->validated());

        return new MenuResource($menu->load('parentMenu', 'module'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \App\Http\Resources\MenuResource
     */
    public function show(Request $request, Menu $menu)
    {
        return new MenuResource($menu->load('parentMenu', 'module'));
    }

    /**
     * @param \App\Http\Requests\MenuUpdateRequest $request
     * @param \App\Models\Menu $menu
     * @return \App\Http\Resources\MenuResource
     */
    public function update(MenuUpdateRequest $request, Menu $menu)
    {
        $menu->update($request->validated());

        return new MenuResource($menu->load('parentMenu', 'module'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Menu $menu)
    {
        $menu->delete();

        return response()->noContent();
    }
}
