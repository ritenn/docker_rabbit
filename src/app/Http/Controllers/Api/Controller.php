<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * @param array $data
     * @param int $status
     * @param string $message
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function responseSuccess(
        array $data = [],
        int $status = 200,
        string $message = 'Success.',
        array $headers = [],
    ) : JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $status, $headers);
    }

    /**
     * @param array $data
     * @param int $status
     * @param string $message
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function responseFailed(
        array $data = [],
        int $status = 422,
        string $message = 'Error',
        array $headers = []
    ) : JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $status, $headers);
    }
}
