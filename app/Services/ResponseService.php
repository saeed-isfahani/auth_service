<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ResponseService
{
    private mixed $data = [];

    /**
     * message
     *
     * @param mixed $data
     * @return ResponseService
     */
    public function data(mixed $data = []): ResponseService
    {
        $this->data = $data;

        return $this;
    }

    /**
     * send
     *
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'data' => $this->data,
            'server_time' => Carbon::now(),
        ], $statusCode);
    }

}