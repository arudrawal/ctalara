<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorProfile extends Model
{
    use HasFactory;
    protected $table = 'sponsor_profiles';
    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sponsor_id', 'name','description',
                            'created_at', 'created_by', 'updated_at', 'updated_by'];
    
    public function permissions() {
        return $this->hasMany(SponsorProfilePermission::class, 'sponsor_profile_id', 'id');
    }
    protected $dateFormat = 'U';
}
