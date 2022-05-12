<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleStoreRequest;
use App\Http\Requests\ModuleUpdateRequest;
use App\Http\Resources\ModuleCollection;
use App\Http\Resources\ModuleResource;
use App\Models\MenuAuthorization;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ModuleController extends Controller
{

    private $withList = [
        'menus',
        'menus.parentMenu',
        'menus.module'
    ];

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ModuleCollection
     */
    public function index(Request $request)
    {
        $modules = Module::latest()->get();

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

    public function myList(Request $request)
    {
        $menuAuthorizationCount = MenuAuthorization::count();
        $menus = [];
        $modules = [];
        $moduleIds = [];
        
        // // implement only if there is at least one assigned privilege
        // // else just  grant global privileges, give access to all menus and modules
        if($menuAuthorizationCount > 0){

            $currentUserPrivileges = auth()->user()->privileges()->pluck("privileges.id");

            Log::debug("current user privileges: " . $currentUserPrivileges );

            // get all menus assigned to current users' privilege
            $menus = MenuAuthorization::whereNull('privilege_id')
                                                    ->orWhereIn('privilege_id', $currentUserPrivileges)
                                                    ->with('menu')
                                                    ->get()
                                                    ->pluck('menu');

            

            $menus = $menus->filter(function($query){
                return $query->is_active;
            });

            // Log::debug("Menus: " . $menus );

            $menus = $menus->sortBy(function($query) {
                return $query->order;
            });
            
            // get the modules of all menus in $menus
            $moduleIds = $menus->map(function($item, $key) {
               return $item['module_id'];
            });

            // get the modules of all menus in $menus
            $menuIds = $menus->map(function($item, $key) {
               return $item['id'];
            });

            // Log::debug("current user Modules: " . $moduleIds );

            $modules = Module::where('active_id', 1)->whereIn('id', $moduleIds)->with([
                'menus' => function($query) use($menuIds) {
                    $query->whereIn('id', $menuIds);
                },
                'menus.parentMenu',
                'menus.module'
            ])->get();
            $modules->menus = $menus;

        }else{
            $modules = Module::with($this->withList)->where('active_id', 1)->get();
        }

        return ModuleResource::collection($modules);
    }
}
