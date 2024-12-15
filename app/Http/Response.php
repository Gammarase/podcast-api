<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as BaseResponse;

class Response extends BaseResponse
{
    public static function success(mixed $data, int $status = self::HTTP_OK, array $headers = []): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $status, $headers);
    }

    public static function error(string $message, int $status = self::HTTP_INTERNAL_SERVER_ERROR, array $headers = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status, $headers);
    }
}
