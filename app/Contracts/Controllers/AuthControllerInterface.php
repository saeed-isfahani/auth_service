<?php

namespace App\Contracts\Controllers;

interface AuthControllerInterface
{

    /**
     * Send a Mobile Verification to user
     *
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/api/v1/login",
     *     operationId="login",
     *     tags={"Login"},
     *     summary="Login User",
     *     description="Login registered user",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *                  type="object",
     *                  required={"mobile","password"},
     *                  @OA\Property(property="mobile", type="text"),
     *                  @OA\Property(property="password", type="text"),
     *            ),
     *        ),
     *    ),
     *
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(response=200,description="Successful operation (login and get token)"),
     *      @OA\Response(response=400,description="Bad Request"),
     *      @OA\Response(response=401,description="Credential is worng"),
     *      @OA\Response(response=404,description="Resource not found")
     * )
     */
    public function login();

    /**
     * Send a Mobile Verification to user
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/v1/check-token",
     *     operationId="check_token",
     *     tags={"Check token"},
     *     summary="Check token",
     *     description="Check logged-in user token",
     *
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(response=200,description="Successful operation (login and get token)"),
     *      @OA\Response(response=400,description="Bad Request"),
     *      @OA\Response(response=401,description="Credential is worng"),
     *      @OA\Response(response=404,description="Resource not found")
     * )
     */
    public function checkToken();

    /**
     * Send a Mobile Verification to user
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/v1/logout",
     *     operationId="logout",
     *     tags={"Logout"},
     *     summary="Logout User",
     *     description="Logout registered user",
     *
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(response=200,description="Successful operation (login and get token)"),
     *      @OA\Response(response=401,description="Credential is worng"),
     *      @OA\Response(response=404,description="Resource not found")
     * )
     */
    public function logout();
}
