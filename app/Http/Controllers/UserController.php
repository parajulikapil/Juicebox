<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserController extends AbstractRestController
{
    /**
     * Get user
     * 
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return $this->success($user->toArray());
    }
}
