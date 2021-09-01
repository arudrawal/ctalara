<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectVisit extends Model
{
    use HasFactory;
    protected $table = 'subject_visits';
    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'uuid','subject_id','subject_uuid',
        'visit_num','visit_serial_num','protocol_visit_id', 
        'visit_status_id','form_status_id','locked_at',
        'started_at','ended_at','dob',
        'created_at', 'created_by', 'updated_at', 'updated_by'];
}
