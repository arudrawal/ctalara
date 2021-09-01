<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProtocolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'sponsor_id' => $this->sponsor_id,
            'code' => $this->code,
            'rev' => $this->rev,
            'description' => $this->description,
            'phase' => $this->phase,
            'product' => $this->product,
            'drafted_at' => $this->drafted_at,
            'studies' => 0, 
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    /**
     * Indicates if the resource's collection keys should be preserved.
     *
     * @var bool
     */
    public $preserveKeys = false;
}
