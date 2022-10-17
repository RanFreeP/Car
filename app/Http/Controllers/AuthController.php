<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth",
     *     summary="Авторизация",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     oneOf={
     *                     	   @OA\Schema(type="string"),
     *                     }
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"name": "79990594565", "password": "12345qwerty"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="'name' => ['required', 'string', 'min:11', 'max:12'] <br />
    'password' => ['required', 'string', 'min:5', 'max:30']",
     *         @OA\JsonContent(
     *          example={"token": "5|8p5vQUtXUBVWAMEOCbvO5ZVsg6IAh5tHobt35gRD"}
     *         ),
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Validation error",
     *     ),
     *          @OA\Response(
     *         response="402",
     *         description="Логин не зарегистрирован!",
     *     ),
     *          @OA\Response(
     *         response="401",
     *         description="Предоставленные учетные данные неверны.",
     *     ),
     * )
     */
    public function auth(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:4', 'max:12'],
            'password' => ['required', 'string', 'min:5', 'max:30']
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 403);
        }

        $user = User::where('name', $request->name)->first();

        if (!$user) {
            return response()->json(['error' => ['description' => 'Логин не зарегистрирован!'],], 402);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => ['description' => 'Предоставленные учетные данные неверны.'],], 401);
        }


        $user->tokens()->delete();

        return response()->json(['token' => $user->createToken($request->name)->plainTextToken]);
    }
}
