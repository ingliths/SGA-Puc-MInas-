<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    function login(): JsonResponse
    {
        try {
            $user = auth()->user();
            $user->api_token = Str::uuid();
            $user->save();
            return $this->sendResponse([
                "name" => $user->name,
                "api_token" => $user->api_token
            ]);
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function index(): JsonResponse
    {
        try {
            return $this->sendResponse(User::all()->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function store(Request $request): JsonResponse
    {
        try {
            $errors = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email|unique:users,email",
                "password" => "required",
            ]);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }
            $request->request->add(['password' => Hash::make($request->get('password'))]);
            $user = new User();
            $user->api_token = Str::uuid();
            $user->save($request->all());
            return $this->sendResponse(User::query()->latest()->first()->toArray(), 'Usuário criado');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function update(Request $request, string $id): JsonResponse
    {
        try {
            $user = User::query()->findOrFail($id);

            $errors = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required",
                "password" => "required",
            ]);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }
            $user->save($request->all());
            return $this->sendResponse($user->toArray(), 'Usuário atualizado');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function show(): JsonResponse
    {
        try {
            $user = auth()->user();
            return $this->sendResponse($user->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function delete(string $id): JsonResponse
    {
        try {
            $user = User::query()->findOrFail($id);
            $user->delete();
            return $this->sendResponse(["id" => $id], 'Usuário deletado');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

}
