<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectFormData extends Model
{
    use HasFactory;
    protected $table = 'subject_form_data';
    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid','subject_visit_form_id','subject_visit_form_uuid',
        'form_id','form_section_id','form_section_q_id', 'form_data_ans','form_data_note','review_status',
        'media_file_name','media_at',
        'created_at', 'created_by', 'updated_at', 'updated_by'];
}
