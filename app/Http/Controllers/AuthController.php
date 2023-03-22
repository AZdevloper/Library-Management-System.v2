<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered; 
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    public function sendConfirmationEmail(){

    }
    public function login(Request $request){
        // return response()->json(['message'=>'ok']);
        $request->validate([
            'email' => 'required|email',
            'password' =>
            [
                'required',
                Password::min(8)
                    ->letters()
            ],
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => ['The provided email is incorrect.']
                ]);  
            }elseif(!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'password' => ['The provided password is incorrect.']
                ]);
               
            }
        }

        return response()->json(["api_token" => $user->createToken('api_token')->plainTextToken]); 
    }
    public function register(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|min:8'
        // ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('member');
        // $mailData = [
        //     'title' => 'Mail from ItSolutionStuff.com',
        //     'body' => 'This is for testing email using smtp.'
        // ];
        // $user->sendConfirmationEmail();
         
        // Mail::to('your_email@gmail.com')->send(new WelcomeMail($mailData));
        
        $user->save();
        return response()->json([
            'message' => 'User registered successfully. Please check your email for confirmation.',
            'user_id'=>$user->id
        ], 201);


    }
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);
    
        if ($user->email_verified_at) {
            return Response()->json([
                'message'=> 'confirmed succsefully'
             ]) ;
        }
    
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
    
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User logged out successfully.'
        ], 200);
    }
    public function changeRole(Request $request){
        $user = User::find($request->id);
        $role = Role::where('name', $request->name)->first();
        if ($user && $role) {
            $user->syncRoles($role);
                     return response()->json([
                'message' => " role changed  successfully for $user->name to $request->name."
            ], 200);
        } else {
            return "User or role not found.";
        }
        
    }
}
