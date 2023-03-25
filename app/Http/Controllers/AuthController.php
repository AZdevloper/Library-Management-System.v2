<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered; 
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
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
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('member');
        $user->save();

        $user->sendConfirmationEmail();        
        return response()->json([
            'message' => 'User registered successfully. Please check your email for confirmation.',
            'user_id'=>$user->id
        ], 201);


    }
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // Verify the signature hash to ensure the URL has not been tampered with
        if (! URL::hasValidSignature($request)) {
            abort(403, 'Invalid URL signature');
        }

        // Verify the hash parameter matches the expected value
        $expectedHash = hash('sha256', 'some_secret_string');
        if ($hash !== $expectedHash) {
            abort(403, 'Invalid verification hash');
        }

        // Verify the user's email address
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        // Redirect the user to a success page
        return redirect()->route('home')->with('success', 'Your email has been verified.');
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User logged out successfully.'
        ], 200);
    }
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if ($response === Password::RESET_LINK_SENT) {
            return back()->with('status', trans($response));
        } else {
            return back()->withErrors(
                ['email' => trans($response)]
            );
        }
    }

    public function broker()
    {
        return Password::broker();
    }
 
    public function sendResetLink(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    
        $response = Password::sendResetLink($request->only('email'));
    
        if ($response === Password::RESET_LINK_SENT) {
            return back()->with('status', trans($response));
        } else {
            return back()->withErrors(['email' => trans($response)]);
        }
    }
       public function manageRoles(Request $request){
        $user = User::find($request->id);
        // $role = Role::where('name', $request->roleName)->first();
        if ($user) {
            $user->syncRoles($request->rolesName);
                     return response()->json([
                'message' => " role changed  successfully for $user->name to $request->name."
            ], 200);
        } else {
            return "User or role not found.";
        }
        
    }
    public function managePermissions(Request $request){
        $role = Role::where('name', $request->roleName)->first();
        $role->syncPermissions($request->permissionsName);
    }

}
