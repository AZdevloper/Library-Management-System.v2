<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        
        

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // Assign the "member" role to the user
        $role = Role::where('name', 'member')->firstOrFail();
        $user->assignRole($role);
        
        $user->save();

       
        return response()->json([
            'message' => 'User registered successfully. Please check your email for confirmation.'
        ], 201);

        $user->sendConfirmationEmail();

    }
}
