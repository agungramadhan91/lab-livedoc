<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use \Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query()->get();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $create_user = DB::transaction(function() use ($request)
        {
            $create_user = User::query()->create([
                "name"      => $request->name,
                "email"     => $request->email,
                "password"  => $request->password,
            ]);

            return $create_user;
        });

        return new UserResource($create_user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $update = DB::transaction(function() use ($request, $user)
        {
            $update = $user->update([
                "name"      => $request->name ?? $user->name,
                "email"     => $request->email ?? $user->email,
                "password"  => $request->password ?? $user->password,
            ]);

            return $update;
        });

        if(!$update){
            return new JsonResponse([
                "error" => ["Failed to update!"]
            ], 400);
        }

        return new UserResource($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $delete = $user->forceDelete();

        if(!$delete){
            return new JsonResponse([
                "error" => ["Could not delete resource!"]
            ], 400);
        }

        return new JsonResponse([
            'data' => "succes"
        ]);
    }
}
