<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    use HasFactory;
    protected $table = 'protocols';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sponsor_id','code', 'rev', 'description', 'phase', 'product', 'drafted_at',
                            'created_at', 'created_by', 'updated_at', 'updated_by'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [    ];
    /**
     * Multiple studies can be created from one protocol.
     */
    public function studies() {
        return $this->hasMany(Study::class, 'protocol_id', 'id');
    }
    /**
     * Each protocol has one sponsor
     */
    public function sponsor() {
        return $this->hasOne(Sponsor::class, 'sponsor_id', 'id');
    }
}
