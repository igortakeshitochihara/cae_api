<?php

namespace App\Models;

use App\Traits\UseHash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    use HasFactory, UseHash;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'availability',
        'room_id'
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

    public function room()
    {
        return $this->hasOne('App\Models\Room', 'id', 'room_id')->first()->makeHidden('id');
    }
}
