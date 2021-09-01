<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sponsor extends Model
{
    use HasFactory;
    protected $table = 'sponsors';
    protected $primaryKey = 'id';
    public $timestamps = false;
    //const CREATED_AT = 'created_at';
    //const UPDATED_AT = 'updated_at';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','code', 'address',
                           'created_at', 'created_by', 'updated_at', 'updated_by'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [    ];
    /**
     * One sponsor can have multiple contacts.
     */
    public function contacts() {
        return $this->hasMany(SponsorContact::class, 'sponsor_id', 'id');
    }
    /**
     * Sponsor can have multiple protocols.
     */
    public function protocols() {
        return $this->hasMany(Protocol::class, 'sponsor_id', 'id');
    }
}
