<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {

        $users = User::paginate(10);

        return view('pages/admin/users',compact('users'));
    }

    public function tambahUser(Request $req)
    {
        // Validate the input data
        $validatedData = $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:0,1,2', // Example for role validation, adjust as needed
        ]);

        // Create a new user instance and save it
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']); // Encrypt the password
        $user->plain_password = $validatedData['password']; // Encrypt the password
        $user->type = $validatedData['role'];
        $user->save();

        return redirect('/users')->with('success', 'User added successfully!');
    }

    public function editUser(Request $req)
    {
        $id = $req->input('id');
        $user = User::find($id);
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->type = $req->input('role');
        $user->save();
        return redirect('/users')->with('success', 'User updated successfully!');
    }

    public function hapusUser(Request $req)
    {
        $id = $req->input('id');
        $user = User::find($id);
        $user->delete();
        return redirect('/users')->with('success', 'User deleted successfully!');
    }

}
