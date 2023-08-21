<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
{
    public static $wrap = null;

    public function __construct(private bool $isAuthenticated, private string $name, private bool $isAdmin, private ?string $token)
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
        $data = [
            'authenticated' => $this->isAuthenticated,
            'name' => $this->name,
            'admin' => $this->isAdmin,
        ];

        if (!empty($this->token)) {
            $data['token'] = $this->token;
        }

        return $data;
    }
}
