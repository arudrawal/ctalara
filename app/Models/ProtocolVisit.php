<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolVisit extends Model
{
    use HasFactory;
    protected $table = 'protocol_visits';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['protocol_id','order', 'visit_type', 'name', 'description', 
                        'ref_visit_id', 'range_start', 'range_end', 'range_unit',
                        'created_at', 'created_by', 'updated_at', 'updated_by'];
    public function forms()
    {
        return $this->hasMany(ProtocolVisitForm::class, 'visit_id', 'id');
    }
}
