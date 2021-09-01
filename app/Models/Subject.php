<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subjects';
    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid','study_id','site_id',
        'number','code','code1', 'code1_name','code2','code2_name',
        'initials','gender','dob','enrolled_at','locked_at', 'subject_status_id',
        'created_at', 'created_by', 'updated_at', 'updated_by'];
}
