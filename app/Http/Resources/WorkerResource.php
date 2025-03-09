<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'roles'=> RoleResource::collection($this->whenLoaded('roles')),
            'created_at' => $this->created,
            //'updated_at' => $this->updated_at,
        ];
    }
}
