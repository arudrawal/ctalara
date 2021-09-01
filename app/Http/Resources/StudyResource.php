<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudyResource extends JsonResource
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
        $dts = new \DateTime();$dts->setTimestamp($this->start_at);
        $dte = new \DateTime();$dte->setTimestamp($this->end_at);
        return [
            'id' => $this->id,
            'protocol_id' => $this->protocol_id,
            'num' => $this->num,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'start_at' => $this->start_at,
            'display_start_at' => $dts->format('m/d/Y'),
            'end_at' => $this->end_at,
            'display_end_at' => $dte->format('m/d/Y'),
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
