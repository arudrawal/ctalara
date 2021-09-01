<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorUserProfile extends Model
{
    use HasFactory;
    protected $table = 'sponsor_user_profiles';
    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sponsor_id', 'user_id', 'sponsor_profile_id',
                'created_at', 'created_by', 'updated_at', 'updated_by'];
    
    protected function permissions() {
        return $this->hasMany(SponsorProfilePermission::class, 'sponsor_profile_id', 'sponsor_profile_id');
    }
    protected $dateFormat = 'U';
}
