<?php

namespace App\Models;

use App\Traits\UseHash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory, UseHash;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    public function keysUnavailable()
    {
        return $this->hasMany('App\Models\Key', 'room_id', 'id')->where('availability', 'unavailable')->get();
    }

    public function keys()
    {
        return $this->hasMany('App\Models\Key', 'room_id', 'id')->get();
    }
}
