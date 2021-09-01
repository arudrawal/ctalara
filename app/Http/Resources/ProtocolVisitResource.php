<?php

namespace App\Http\Resources;

use App\Constants\VisitType;
use App\Constants\VisitRangeUnit;
use App\Constants\AdminForm;

use Illuminate\Http\Resources\Json\JsonResource;

class ProtocolVisitResource extends JsonResource
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
        $visit_forms = [];
        foreach ($this->forms as $formModal) {
            $visit_array = $formModal->toArray();
            $visit_array['display_form'] = AdminForm::getById($formModal->form_id);
            $visit_forms[] = $visit_array;
        }
        return [
            'id' => $this->id,
            'protocol_id' => $this->protocol_id,
            'order' => $this->order,
            'type' => $this->type,
            'display_type' => VisitType::getById($this->type),
            'name' => $this->name,
            'description' => $this->description,
            'ref_visit_id' => $this->ref_visit_id ? $this->ref_visit_id : $this->id,
            'range_start' => $this->range_start,
            'range_end' => $this->range_end,
            'range_unit' => $this->range_unit,
            'display_range_unit' => VisitRangeUnit::getById($this->range_unit),
            'visit_forms' => $visit_forms,
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
