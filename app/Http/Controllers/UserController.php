<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'role' => 'required'
        ]);

        User::create([
            'name' => $r->name,
            'email' => $r->email,
            'password' => Hash::make($r->password),
            'role' => $r->role
        ]);

        return back()->with('success','User berhasil ditambah');
    }

    public function update(Request $r, $id)
    {
        $user = User::findOrFail($id);

        $r->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required'
        ]);

        $data = [
            'name' => $r->name,
            'email' => $r->email,
            'role' => $r->role
        ];

        if($r->password){
            $data['password'] = Hash::make($r->password);
        }

        $user->update($data);

        return back()->with('success','User berhasil diupdate');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('error','User berhasil dihapus');
    }
}