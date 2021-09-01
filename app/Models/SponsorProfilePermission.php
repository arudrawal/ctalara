<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorProfilePermission extends Model
{
    use HasFactory;
    protected $table = 'sponsor_profile_permissions';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sponsor_profile_id', 'secure_model_id','view','update', 'delete',
                            'json_actions', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['json_actions'];
    protected $dateFormat = 'U';
}
