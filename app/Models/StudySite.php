<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySite extends Model
{
    use HasFactory;
    protected $table = 'study_sites';
    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['study_id','code','name', 'department', 
                    'address', 'city', 'state', 'country',
                    'contact', 'phone', 'email',
                    'created_at', 'created_by', 'updated_at', 'updated_by'];
}
