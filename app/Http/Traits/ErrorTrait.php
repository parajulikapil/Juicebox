<?php

namespace App\Http\Traits;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ErrorTrait
{
    /**
     * Success response
     * 
     * @param array|Collection|string $body
     * @param int $statusCode
     * 
     * @return JsonResponse
     */
    public function success(array|Collection|string|Paginator|Model $body, int $statusCode = 200): JsonResponse
    {
        if (!is_string($body)) {
            $body = [
                "data" => $body
            ];
        } else {
            $body = [
                "message" => $body
            ];
        }

        if (!$this->request->isMethod('GET')) {
            $statusCode = 201;
        }

        return response()->json($body, $statusCode);
    }

    /**
     * Error response
     * 
     * @param string $message
     * @param int $statusCode
     * 
     * @return JsonResponse
     */
    public function error(string $message, int $statusCode = 400): JsonResponse
    {        
        return response()->json([
            'message' => $message
        ], $statusCode);
    }
    

    /**
     * Error response for page not found
     * 
     * @return JsonResponse
     */
    public function notFound(): JsonResponse
    {        
        return response()->json([
            'message' => "Could not found. Please check your inputs."
        ], 404);
    }

    /**
     * Error response for forbidden
     * 
     * @return JsonResponse
     */
    public function forbidden(): JsonResponse
    {        
        return response()->json([
            'message' => "User cannot access this resource"
        ], 403);
    }

    /**
     * Error response for unauthorize
     * 
     * @return JsonResponse
     */
    public function unauthorize(): JsonResponse
    {        
        return response()->json([
            'message' => "User is unauthorize to access"
        ], 401);
    }

    /**
     * Error response for internal server error     
     * 
     * @return JsonResponse
     */
    public function internalServerError(): JsonResponse
    {        
        return response()->json([
            'message' => "Something went wrong, please try again"
        ], 500);
    }
}