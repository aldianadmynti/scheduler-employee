<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $datas = User::where('id', '!=', auth()->user()->id)->get();
        return view('pages.user', compact('datas'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        $validate['role_id'] = 2;
        $validate['password'] = bcrypt($validate['password']);

        if ($user = User::create($validate)) {
            return redirect()->back()->with('success', 'User created successfully');
        }

        return back()->withErrors(['error' => 'Failed to create user']);
    }

    public function edit(User $user)
    {
        return view('pages.user-edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        if ($user->update($validate)) {
            return redirect()->back()->with('success', 'User updated successfully');
        }

        return back()->withErrors(['error' => 'Failed to update user']);
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            return redirect()->route('user.index')->with('success', 'User deleted successfully');
        }

        return back()->withErrors(['error' => 'Failed to delete user']);
    }

    public function changePassword(Request $request, User $user)
    {
        $validate = $request->validate([
            'password' => 'required'
        ]);

        $validate['password'] = bcrypt($validate['password']);

        if ($user->update($validate)) {
            return redirect()->back()->with('success', 'Password updated successfully');
        }

        return back()->withErrors(['error' => 'Failed to update password']);
    }
}
