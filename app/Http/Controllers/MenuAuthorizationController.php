<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuAuthorizationStoreRequest;
use App\Http\Requests\MenuAuthorizationUpdateRequest;
use App\Http\Resources\MenuAuthorizationCollection;
use App\Http\Resources\MenuAuthorizationResource;
use App\Models\Menu;
use App\Models\MenuAuthorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuAuthorizationController extends Controller
{

    const LOG_KEY = "[MenuAuthorizationController]";
    
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\MenuAuthorizationCollection
     */
    public function index(Request $request)
    {
        $menuAuthorizations = MenuAuthorization::with('privilege', 'menu')->latest()->get();

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
        return new MenuAuthorizationResource($menuAuthorization->load('privilege', 'menu'));
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

    public function add(Request $request)
    {    

        $rules = [
            'menu_id' => 'required_if:AccessLevelOption,3|array',
            'menu_id.*' => 'integer|numeric|exists:App\Models\Menu,id',
            'privilege_id' => 'nullable|integer|numeric|exists:App\Models\Privilege,id',
            'access_level_option' => 'required|integer',
            'privilege_to_copy' => 'required_if:AccessLevelOption,2|integer'
        ];
        
        $data = $this->validate($request, $rules);

        if($data['access_level_option'] == 1)
        {
            $data['menu_id'] = Menu::all()->pluck('id')->toArray();
            
        }else if($data['access_level_option'] == 2)
        {
            $data['menu_id'] = MenuAuthorization::where('privilege_id', $data['privilege_to_copy'])->get()->pluck('menu_id')->toArray();
        }
          
        $authorizationIds = $this->addMenuAuthorizations($data);

        return jsend_success(MenuAuthorizationResource::collection(MenuAuthorization::whereIn('id', $authorizationIds)->with(
            'menu',
            'privilege'
        )->get()), 201);
        
    }

    public function addMenuAuthorizations($payload)
    {
        $authIds = [];
        
        foreach($payload['menu_id'] as $key => $menu) {
            $privilege = empty($payload['privilege_id']) ? null : $payload['privilege_id'];

            if(MenuAuthorization::where(['privilege_id' => $privilege, 'menu_id' => $menu])->exists()) continue;

            $menuAuthorization = new MenuAuthorization();
            $menuAuthorization->privilege_id = $privilege;
            $menuAuthorization->menu_id = $menu;
            $menuAuthorization->save();
            $authIds[] = $menuAuthorization->id;
            Log::info(self::LOG_KEY. " [Saved] Menu Authorization id: $menuAuthorization->id");
        }

        return $authIds;
        
    }
}
