<?php

namespace App\Http\Controllers;

use App\Domain\Delivery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DeliveryController extends Controller
{
    function index(): JsonResponse
    {
        try {
            return $this->sendResponse(Delivery::all()->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function store(Request $request): JsonResponse
    {
        try {
            $errors = Validator::make($request->all(), [
                "pedido_id" => "required",
                "shipping_company" => "required",
            ]);

            $request->request->add(['track_code' => Str::uuid()]);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }
            (new Delivery())->save($request->all());
            return $this->sendResponse(Delivery::query()->latest()->first()->toArray(), 'Entrega criada');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function update(Request $request, string $id): JsonResponse
    {
        try {
            $model = Delivery::query()->findOrFail($id);

            $errors = Validator::make($request->all(), [
                "pedido_id" => "required",
                "shipping_company" => "required",
            ]);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }
            $model->save($request->all());
            return $this->sendResponse($model->toArray(), 'Entrega atualizada');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function show(string $id): JsonResponse
    {
        try {
            $model = Delivery::query()->findOrFail($id);
            return $this->sendResponse($model->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function delete(string $id): JsonResponse
    {
        try {
            $model = Delivery::query()->findOrFail($id);
            $model->delete();
            return $this->sendResponse(["id" => $id], 'Entrega deletada');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

}
