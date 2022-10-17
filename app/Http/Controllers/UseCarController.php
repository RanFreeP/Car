<?php

namespace App\Http\Controllers;

use App\Http\Helpers\InputHelper;
use App\Http\Requests\UseCarRequest;
use App\Models\UseCar;

class UseCarController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/useCar",
     *     summary="Привязка автомобиля к пользователю",
     *     tags={"UseCar"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="car_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer"
     *                 ),
     *                 example={"car_id": "1",
     *                          "user_id": "1",
     *                          }
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="'car_id' => ['required', 'numeric',]<br />
    'user_id' => ['required', 'numeric',]<br />",
     *         @OA\JsonContent(
     *          example={"'message' => 'OK', 'description' => $newUseCar"}
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="'message' => 'error', 'error' => 'Сообщение ошибки'",
     *     ),
     * )
     */
    public function useCar(UseCarRequest $request)
    {
        try {
            $requestArray = $request->validated();

            $data = InputHelper::clearTags($requestArray);

            if (UseCar::where('car_id', $data['car_id'])->first() || UseCar::where('user_id', $data['user_id'])->first()) {
                return response()->json([
                    'message' => 'error',
                    'error' => 'Автомобиль занят'
                ], 400);
            }

            $newUseCar = new UseCar;

            $newUseCar->car_id = $data['car_id'];
            $newUseCar->user_id = $data['user_id'];

            $newUseCar->save();

            return response()->json([
                'message' => 'OK',
                'description' => $newUseCar
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'error',
                'error' => $exception->getMessage()
            ], 400);
        }

    }
}
