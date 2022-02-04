<?php

namespace App\Http\Controllers;

use App\Domain\Request as TRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RequestController extends Controller
{
    function index(): JsonResponse
    {
        try {
            return $this->sendResponse(TRequest::all()->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function store(Request $request): JsonResponse
    {
        try {
            $errors = Validator::make($request->all(), [
                "client" => "required",
                "address" => "required",
                "products" => "required|array",
            ]);

            $request->request->add(['status' => 'SOLICITADO']);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }
            (new TRequest())->save($request->all());
            return $this->sendResponse(TRequest::query()->latest()->first()->toArray(), 'Pedido criada');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function update(Request $request, string $id): JsonResponse
    {
        try {
            $category = TRequest::query()->findOrFail($id);

            $errors = Validator::make($request->all(), [
                "client" => "required",
                "address" => "required",
                "products" => "required|array",
            ]);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }
            $category->save($request->all());
            return $this->sendResponse($category->toArray(), 'Pedido atualizado');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function show(string $id): JsonResponse
    {
        try {
            $category = TRequest::query()->findOrFail($id);
            return $this->sendResponse($category->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function delete(string $id): JsonResponse
    {
        try {
            $category = TRequest::query()->findOrFail($id);
            $category->delete();
            return $this->sendResponse(["id" => $id], 'Pedido deletado');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

}
