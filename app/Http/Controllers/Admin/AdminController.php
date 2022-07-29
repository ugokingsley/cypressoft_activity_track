<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\ActivityCalendar;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreUserRequest;

class AdminController extends Controller
{
    /**
     * view all users; only users with admin access
     * can view
     * @param \App\Models\User $users
     * @return $users
     */

    public function index()
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    /**
     * view user created form, only users with
     * admin access
     */
    public function create()
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::pluck('title', 'id');
        return view('users.create', compact('roles'));
    }

    /**
     * save newly created user to database; only users with admin access
     * can view
     * @param \App\Models\User $users
     * @return $users
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $user->roles()->sync($request->input('roles', []));
        return redirect()->route('users');
    }

    /**
     * delete user; only users with admin access
     * @param \App\Models\User $users
     * @return $users
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user->delete();
        return redirect()->route('users');
    }
}
