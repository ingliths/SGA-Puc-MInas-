<?php

namespace App\Http\Controllers;

use App\Domain\Category;
use App\Domain\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    function index(): JsonResponse
    {
        try {
            return $this->sendResponse(Category::all()->toArray());
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
            (new Category())->save($request->all());
            return $this->sendResponse(Category::query()->latest()->first()->toArray(), 'Categoria criada');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function update(Request $request, string $id): JsonResponse
    {
        try {
            $category = Category::query()->findOrFail($id);

            $errors = Validator::make($request->all(), [
                "name" => "required",
            ]);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }
            $category->save($request->all());
            return $this->sendResponse($category->toArray(), 'Categoria atualizada');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function show(string $id): JsonResponse
    {
        try {
            $category = Category::query()->findOrFail($id);
            return $this->sendResponse($category->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function delete(string $id): JsonResponse
    {
        try {
            $category = Category::query()->findOrFail($id);
            $category->delete();
            return $this->sendResponse(["id" => $id], 'Categoria deletada');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

}
