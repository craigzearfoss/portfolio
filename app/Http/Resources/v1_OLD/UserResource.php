<?php

namespace App\Http\Resources;

use App\Models\System\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    const int NUM_PER_PAGE = 20;

    /**
     * Display a listing of the user.
     */
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return User::findOrFail($request->id);
    }
}
