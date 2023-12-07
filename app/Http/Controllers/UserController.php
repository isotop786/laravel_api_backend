<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function __construct() {
        // $this->middleware('auth');
     }

    public function index()
    {
        // return User::with('role')->paginate();
        return UserResource::collection(User::with('role')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        // dd($request);
        // $user = User::create($request->all());
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            // 'password' => Hash::make($request->input('password'))
            'password' => Hash::make(1234)
        ]);
        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return User::findOrFail($id);
        $user = User::findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);

        $user->update($request->only('first_name','last_name','email','role_id'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function user()
    {
        Auth::user()->role;
        return Auth::user();
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only('first_name','last_name','email','role_id'));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);
    }
}
