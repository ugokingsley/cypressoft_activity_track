<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class APIAuthController extends Controller
{
    /**
     * register as a user via API
     * @param \App\Models\User $users
     * @return $users
     */

    public function register(Request $request){
        $validated = $request->validate([
                            'name' => 'required|string|max:255',
                            'email' => 'required|string|email|max:255|unique:users',
                            'password' => 'required|string|min:8',]);

        $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
                    'message' => 'success',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
        ]);
    }

    /**
     * user login via API
     * can view
     * @param \App\Models\User $users
     * @return $users
     */

    public function login(Request $request){
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
            'message' => 'You have entered wrong details'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
                'message' => 'success',
                'access_token' => $token,
                'token_type' => 'Bearer',
        ]);
    }

}
