<?php

namespace App\Http\Controllers;

use App\Domain\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class VendorController extends Controller
{
    function index(): JsonResponse
    {
        try {
            return $this->sendResponse(Vendor::all()->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function store(Request $request): JsonResponse
    {
        try {
            $errors = Validator::make($request->all(), [
                "name" => "required",
            ]);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }
            (new Vendor())->save($request->all());
            return $this->sendResponse(Vendor::query()->latest()->first()->toArray(), 'Fornecedor criado');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function update(Request $request, string $id): JsonResponse
    {
        try {
            $vendor = Vendor::query()->findOrFail($id);

            $errors = Validator::make($request->all(), [
                "name" => "required",
            ]);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }
            $vendor->save($request->all());
            return $this->sendResponse($vendor->toArray(), 'Fornecedor atualizado');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function show(string $id): JsonResponse
    {
        try {
            $vendor = Vendor::query()->findOrFail($id);
            return $this->sendResponse($vendor->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function delete(string $id): JsonResponse
    {
        try {
            $vendor = Vendor::query()->findOrFail($id);
            $vendor->delete();
            return $this->sendResponse(["id" => $id], 'Fornecedor deletado');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

}
