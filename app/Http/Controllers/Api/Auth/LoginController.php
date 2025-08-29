<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\Concrete\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Exception;

class LoginController extends Controller
{
    protected $user_service;
    public function __construct(
        UserService  $user_service
    ) {
        $this->user_service = $user_service;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Woops! Your form has errors. Please fix them and submit again.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = $this->user_service->getByEmail($request->email);

            if(isset($user) || !empty($user))
            {
                if (!Auth::attempt($request->only('email', 'password'))) {
                    $validator->errors()->add('credentials', 'Woops! Invalid login credentials. Please try again.');

                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $tokenResult = $user->createToken('flynetApiToken')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'message' => 'Well done! You are loggedin successfully.',
                    'user' => $user,
                    'accessToken' => $tokenResult,
                ], 200);

            } else {
                $validator->errors()->add('credentials', 'No account associated with this email.');

                return response()->json(['errors' => $validator->errors()], 422);
            }

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'You are logged out successfully.'
        ], 200);
    }
}
