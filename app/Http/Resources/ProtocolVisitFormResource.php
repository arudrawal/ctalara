<?php

namespace App\Http\Resources;

use App\Constants\VisitType;
use App\Constants\VisitRangeUnit;

use Illuminate\Http\Resources\Json\JsonResource;

class ProtocolVisitFormResource extends JsonResource
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
            'visit_id' => $this->visit_id,
            'form_id' => $this->form_id,
            'order' => $this->order,
            'optional' => $this->optional,
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
