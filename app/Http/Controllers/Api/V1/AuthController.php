<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //  REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'nullable'
        ]);
       try {
           $user = User::create([
               'name' => $request->name,
               'email' => $request->email,
               'password' => $request->password,
               'phone' => $request->phone,
               'role' => 'customer',
           ]);
           return response()->json($user);
       } catch (\Exception $e) {
           return response()->json([
               'error' => $e->getMessage()
           ]);
       }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $user
        ]);
    }

    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first(); //  fixed
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    // GET USER
   public function user(Request $request)
   {
       $user = $request->user();
       return response()->json([
           'status' => true,
           'message' => 'User details fetched successfully',
           'data' => [
               'id' => $user?->id,
               'name' => $user?->name,
               'email' => $user?->email,
               'number' => $user?->phone,
               'profile_image' => $user?->profile_image,
               'is_verified' => $user?->is_verified,
               'created_at' => $user?->created_at,
           ]
       ]);
   }

    //Update Profile
    public function updateProfile(Request $request)
    {
        $user = $request->user();
            $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:6',
            'profile_image' => 'nullable|image'
        ]);
            //  Update basic fields
        if ($request->filled('name')) {
            $user->name = $request->name;
        }
            if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }
            // Update password
        if ($request->filled('password')) {
            $user->password = $request->password;
        }
        // Upload profile image
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $path;
        }
            $user->save();
          return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'profile_image' => $user->profile_image
                    ? asset('storage/' . $user->profile_image)
                    : null,
            ]
        ]);
    }

    //  LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}
