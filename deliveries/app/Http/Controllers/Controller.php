<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;
use Exception;

class Controller extends BaseController
{
    /**
     * success response method.
     *
     * @param array $result
     * @param string $message
     * @return JsonResponse
     */
    public function sendSimpleJson(array $result = []): JsonResponse
    {
        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * success response method.
     *
     * @param array $result
     * @param string $message
     * @return JsonResponse
     */
    public function sendResponse(array $result = [], string $message = ''): JsonResponse
    {
        $response = [
            'data'             => $result,
            'friendly_message' => $message,
        ];

        if (!empty($result) || !empty($message)) {
            if (!empty($result)) {
                $response['data'] = $result;
            }

            if (!empty($message)) {
                $response['friendly_message'] = $message;
            }
        }

        return response()->json($response, Response::HTTP_OK);
    }


    /**
     * return error response.
     *
     * @param string $error
     * @param Exception $exception
     * @param int $code
     * @return JsonResponse
     */
    public function sendError(string $error, Exception $exception, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $response = [
            'message' => $error,
        ];

        $response['server_error'] = $exception->getMessage();
        //$response['server_trace'] = $exception->getTraceAsString();
        $response['server_file'] = $exception->getFile();
        $response['server_line'] = $exception->getLine();

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @return JsonResponse
     */
    public function sendUnauthorized(): JsonResponse
    {
        $response = [
            'friendly_message' => 'Unauthorized access',
        ];

        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * return error response.
     *
     * @param string $error
     * @param array $errorMessages
     * @param int $code
     * @return JsonResponse
     */
    public function sendBadRequest(string $error, array $errorMessages = [], int $code = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        $response = [
            'friendly_message' => $error,
        ];

        if (!empty($errorMessages)) {
            //$response['data'] = $errorMessages;
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @return JsonResponse
     */
    public function sendNotFound(): JsonResponse
    {
        $response = [
            'friendly_message' => 'Not Found',
        ];

        return response()->json($response, Response::HTTP_NOT_FOUND);
    }
}
