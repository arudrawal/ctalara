<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolVisitForm extends Model
{
    use HasFactory;
    protected $table = 'protocol_visit_forms';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['protocol_id', 'visit_id','form_id', 'order', 'optional',
                        'created_at', 'created_by', 'updated_at', 'updated_by'];
    public function visit()
    {
        return $this->belongsTo(ProtocolVisit::class, 'visit_id');
    }
}
