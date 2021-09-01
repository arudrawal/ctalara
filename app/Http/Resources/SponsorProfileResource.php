<?php

namespace App\Http\Resources;

use App\Constants\SecureModel;

use Illuminate\Http\Resources\Json\JsonResource;

class SponsorProfileResource extends JsonResource
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
        $profile_permissions = [];
        foreach ($this->permissions as $permission) {
            $perm_array = $permission->toArray();
            $perm_array['secure_model'] = SecureModel::getById($permission->secure_model_id);
            $profile_permissions[] = $perm_array;
        }
        return [
            'id' => $this->id,
            'sponsor_id' => $this->sponsor_id,
            'name' => $this->name,
            'description' => $this->description,
            'permissions' => $profile_permissions,
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
