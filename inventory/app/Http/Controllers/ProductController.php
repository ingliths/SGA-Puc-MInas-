<?php

namespace App\Http\Controllers;

use App\Domain\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    function index(): JsonResponse
    {
        try {
            return $this->sendResponse(Product::all()->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function store(Request $request): JsonResponse
    {
        try {
            $errors = Validator::make($request->all(), [
                "description" => "required",
                "price" => "required",
                "quantity" => "required",
                "category_id" => "required|exists:categories,id",
                "vendor_id" => "required|exists:vendors,id",
            ]);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }

          (new Product())->save($request->all());

            return $this->sendResponse(Product::query()->latest()->first()->toArray(), 'Produto criado');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function update(Request $request, string $id): JsonResponse
    {
        try {
            $product = Product::query()->findOrFail($id);

            $errors = Validator::make($request->all(), [
                "description" => "required",
                "price" => "required",
                "quantity" => "required",
                "category_id" => "required|exists:categories,id",
                "vendor_id" => "required|exists:vendors,id",
            ]);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }
            $product->save($request->all());
            return $this->sendResponse($product->toArray(), 'Produto atualizado');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function show(string $id): JsonResponse
    {
        try {
            $product = Product::query()->findOrFail($id);
            return $this->sendResponse($product->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function delete(string $id): JsonResponse
    {
        try {
            $product = Product::query()->findOrFail($id);
            $product->delete();
            return $this->sendResponse(["id" => $id], 'Produto deletado');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

}
