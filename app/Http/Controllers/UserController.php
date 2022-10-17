<?php

namespace App\Http\Controllers;

use App\Http\Helpers\InputHelper;
use App\Http\Requests\AdminUserRequest;
use App\Models\User;

class UserController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/create",
     *     summary="Создание пользователя",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="access_admin",
     *                     type="numeric"
     *                 ),
     *                  @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"name": "Eldar",
     *                          "access_admin": "false",
     *                          "password": "123456",
     *                          }
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="'name' => ['required', 'string', 'min:4', 'max:15']<br />
    'access_admin' => ['required', 'numeric', 'boolean']<br />
    'password' => ['required', 'string', 'min:4', 'max:15']<br />",
     *         @OA\JsonContent(
     *          example={"'message' => 'OK', 'user' => $user"}
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="'message' => 'error', 'error' => 'Сообщение ошибки'",
     *     ),
     * )
     */
    public function create(AdminUserRequest $request)
    {
        try {
            $requestArray = $request->validated();

            $data = InputHelper::clearTags($requestArray);

            $newUser = new User;

            $newUser->name = $data['name'];
            $newUser->access_admin = $data['access_admin'];
            $newUser->password = bcrypt($data['password']);

            $newUser->save();

            return response()->json([
                'message' => 'OK',
                'user' => $newUser
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'error',
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="api/user/{id}",
     *     summary="Редактирование пользователя",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="access_admin",
     *                     type="numeric"
     *                 ),
     *                 example={"name": "Eldar",
     *                          "access_admin": "false",
     *                          }
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="'name' => ['required', 'string', 'min:4', 'max:15']<br />
    'access_admin' => ['required', 'numeric', 'boolean']<br />",
     *         @OA\JsonContent(
     *          example={"'message' => 'OK', 'user' => $user"}
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="'message' => 'error', 'error' => 'Сообщение ошибки'",
     *     ),
     * )
     */
    public function update(AdminUserRequest $request, $id)
    {
        try {
            $requestArray = $request->validated();

            $data = InputHelper::clearTags($requestArray);

            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'error',
                    'error' => 'Пользователь не найден'
                ], 400);
            }

            $user->name = $data['name'] ?? $user->name;
            $user->access_admin = $data['access_admin'] ?? $user->access_admin;

            $user->save();

            return response()->json([
                'message' => 'OK',
                'user' => $user
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'error',
                'error' => $exception->getMessage()
            ], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="api/user/{id}",
     *     summary="Удаление пользователя",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\JsonContent(
     *          example={"'message' => 'OK', 'description' => 'Пользователь успешно удален'"}
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="'message' => 'error', 'error' => 'Сообщение ошибки'",
     *     ),
     * )
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'error',
                    'error' => 'Пользователь не найден'
                ], 400);
            }

            $user->delete();

            return response()->json([
                'message' => 'OK',
                'description' => 'Пользователь успешно удален'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'error',
                'error' => $exception->getMessage()
            ], 400);
        }
    }
}
