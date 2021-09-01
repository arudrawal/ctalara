<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectVisitForm extends Model
{
    use HasFactory;
    protected $table = 'subject_visit_forms';
    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid','subject_visit_id','subject_visit_uuid',
        'form_id','form_status_id','form_order', 'form_sub_order',
        'owner_user_id', 'owner_user_at',
        'created_at', 'created_by', 'updated_at', 'updated_by'];
}
