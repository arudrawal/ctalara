<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorContact extends Model
{
    use HasFactory;
    protected $table = 'sponsor_contacts';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sponsor_id', 'name','address', 'phone', 'mobile', 'email','fax',
                            'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function sponsor() {
        return $this->belongsTo(Sponsor::class, 'sponsor_id', 'id');
    }
}
