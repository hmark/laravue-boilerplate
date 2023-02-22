<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
{
    public static $wrap = null;

    public function __construct(private bool $isAuthenticated, private string $name, private bool $isAdmin)
    {
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'authenticated' => $this->isAuthenticated,
            'name' => $this->name,
            'admin' => $this->isAdmin,
        ];

        return parent::toArray($request);
    }
}
