<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyUserProfile extends Model
{
    use HasFactory;
    protected $table = 'study_user_profiles';
    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','study_id', 'sponsor_profile_id','resource', 
                'created_at', 'created_by', 'updated_at', 'updated_by'];

    protected $dateFormat = 'U';
}
