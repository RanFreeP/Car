<?php

namespace App\Http\Controllers;

use App\Http\Helpers\InputHelper;
use App\Http\Requests\AdminCarRequest;
use App\Models\Car;

class AdminCarController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/car/create",
     *     summary="Создание автомобиля",
     *     tags={"Car"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="mark",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="model",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="year",
     *                     type="integer"
     *                 ),
     *                 example={"mark": "subaru",
     *                          "model": "impreza",
     *                          "year": "2020",
     *                          }
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="'mark' => ['required', 'string', 'min:4', 'max:15']<br />
    'model' => ['required', 'string', 'min:4', 'max:15']<br />
    'year' => ['required', 'integer', 'min:4', 'max:4']<br />",
     *         @OA\JsonContent(
     *          example={"'message' => 'OK', 'car' => $newCar"}
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="'message' => 'error', 'error' => 'Сообщение ошибки'",
     *     ),
     * )
     */
    public function create(AdminCarRequest $request)
    {
        try {
            $requestArray = $request->validated();

            $data = InputHelper::clearTags($requestArray);

            $newCar = new Car;

            $newCar->mark = $data['mark'];
            $newCar->model = $data['model'];
            $newCar->year = $data['year'];

            $newCar->save();

            return response()->json([
                'message' => 'OK',
                'car' => $newCar
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
     *     path="/api/car/{id}",
     *     summary="Редактирование автомобиля",
     *     tags={"Car"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="mark",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="model",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="year",
     *                     type="integer"
     *                 ),
     *                 example={"mark": "subaru",
     *                          "model": "impreza",
     *                          "year": "2020",
     *                          }
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="'mark' => ['required', 'string', 'min:4', 'max:15']<br />
    'model' => ['required', 'string', 'min:4', 'max:15']<br />
    'year' => ['required', 'integer', 'min:4', 'max:4']<br />",
     *         @OA\JsonContent(
     *          example={"'message' => 'OK', 'car' => $car"}
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="'message' => 'error', 'error' => 'Сообщение ошибки'",
     *     ),
     * )
     */
    public function update(AdminCarRequest $request, $id)
    {
        try {

            $requestArray = $request->validated();

            $data = InputHelper::clearTags($requestArray);

            $car = Car::find($id);

            if (!$car) {
                return response()->json([
                    'message' => 'error',
                    'error' => 'Автомобиль не найден'
                ], 400);
            }

            $car->mark = $data['mark'] ?? $car->mark;
            $car->model = $data['model'] ?? $car->model;
            $car->year = $data['year'] ?? $car->year;

            $car->save();

            return response()->json([
                'message' => 'OK',
                'car' => $car
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
     *     path="api/car/{id}",
     *     summary="Удаление автомобиля",
     *     tags={"Car"},
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\JsonContent(
     *          example={"'message' => 'OK', 'description' => 'Автомобиль успешно удален'"}
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
            $car = Car::find($id);

            if (!$car) {
                return response()->json([
                    'message' => 'error',
                    'error' => 'Автомобиль не найден'
                ], 400);
            }

            $car->delete();

            return response()->json([
                'message' => 'OK',
                'description' => 'Автомобиль успешно удален'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'error',
                'error' => $exception->getMessage()
            ], 400);
        }
    }
}
