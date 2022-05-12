<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivilegeDetailStoreRequest;
use App\Http\Requests\PrivilegeDetailUpdateRequest;
use App\Http\Resources\PrivilegeDetailCollection;
use App\Http\Resources\PrivilegeDetailResource;
use App\Models\PrivilegeDetail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PrivilegeDetailController extends Controller
{

    const LOG_KEY = "[PrivilegeDetailController]";

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\PrivilegeDetailCollection
     */
    public function index(Request $request)
    {
        $privilegeDetails = PrivilegeDetail::with('privilegeClass', 'user', 'privilege')->latest()->get();

        return new PrivilegeDetailCollection($privilegeDetails);
    }

    /**
     * @param \App\Http\Requests\PrivilegeDetailStoreRequest $request
     * @return \App\Http\Resources\PrivilegeDetailResource
     */
    public function store(PrivilegeDetailStoreRequest $request)
    {
        $privilegeDetail = PrivilegeDetail::create($request->validated());

        return new PrivilegeDetailResource($privilegeDetail->load('privilegeClass', 'user', 'privilege'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PrivilegeDetail $privilegeDetail
     * @return \App\Http\Resources\PrivilegeDetailResource
     */
    public function show(Request $request, PrivilegeDetail $privilegeDetail)
    {
        return new PrivilegeDetailResource($privilegeDetail->load('privilegeClass', 'user', 'privilege'));
    }

    /**
     * @param \App\Http\Requests\PrivilegeDetailUpdateRequest $request
     * @param \App\Models\PrivilegeDetail $privilegeDetail
     * @return \App\Http\Resources\PrivilegeDetailResource
     */
    public function update(PrivilegeDetailUpdateRequest $request, PrivilegeDetail $privilegeDetail)
    {
        $privilegeDetail->update($request->validated());

        return new PrivilegeDetailResource($privilegeDetail->load('privilegeClass', 'user', 'privilege'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PrivilegeDetail $privilegeDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PrivilegeDetail $privilegeDetail)
    {
        $privilegeDetail->delete();

        return response()->noContent();
    }

    public function add(Request $request)
    {
        try {
            $rules = [
                'privilege_id' => 'required|numeric|exists:App\Models\Privilege,id',
                'privilege_class_id' => 'required|numeric|exists:App\Models\PrivilegeClass,id',
                'user_list'=> ['nullable', 'array'],
                'user_list.*'=> ['exists:\App\Models\User,id']
            ];

            $data = $this->validate($request, $rules);

            DB::beginTransaction();

            if(isset($data['user_list']))
            {
                Log::debug("user list present");
                $this->setIndividualPrivileges($data);
            }

            DB::commit();

        } catch(Exception $ex) {
            DB::rollback();
            throw $ex;
        }

        Log::info(self::LOG_KEY. " [Saved] Privilege Detail");
        return jsend_success(null, 201);
    }

    public function setIndividualPrivileges($data)
    {
        $users = User::all()->whereIn('id', $data['user_list']);

        Log::debug("users: " . $users);

        $this->setPrivileges($users, $data);
    }

    public function setPrivileges($users, $data)
    {
        Log::debug("set privileges");

        foreach ($users as $key => $user) {
            if($user->privileges()->where(['privilege_details.user_id' => $user->id,
                                            'privilege_details.privilege_id' => $data['privilege_id']])
                                            ->exists()) 
            {
                $user->privileges()->where(['privilege_details.user_id' => $user->id,
                                            'privilege_details.privilege_id' => $data['privilege_id']])
                                            ->update(['privilege_class_id' =>$data['privilege_class_id']]);
            } else{
                // bypassing privilege_header table 
                // we use the statusID column in privilege_details table to store PrivilegeClassID foreign key
                // and we use PrivHeaderID column to store PrivilegeID foreign key
                // dd($data);
                $privilege = new PrivilegeDetail();
                $privilege->privilege_id = $data['privilege_id'];
                $privilege->privilege_class_id = $data['privilege_class_id'];
                $privilege->user_id = $user->id;

                $user->privileges->add($privilege);
                $user->push();
            }
            
        }
    }
}
