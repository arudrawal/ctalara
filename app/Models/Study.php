<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    use HasFactory;
    protected $table = 'studies';
    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['protocol_id','status_id', 'name','code', 'description', 'start_at', 'end_at', 
                'created_at', 'created_by', 'updated_at', 'updated_by'];
    public function protocol() {
        return $this->hasOne(Protocol::class, 'protocol_id', 'id');
    }
}
