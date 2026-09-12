<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * Build standard success response.
     */
    public function successResponse($data = [], string $message = 'Success', array $meta = [], int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'meta'    => (object)$meta,
            'errors'  => [],
        ], $code);
    }

    /**
     * Build standard error response.
     */
    public function errorResponse(string $message = 'An error occurred', $errors = [], int $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => (object)[],
            'meta'    => (object)[],
            'errors'  => $errors,
        ], $code);
    }
}
