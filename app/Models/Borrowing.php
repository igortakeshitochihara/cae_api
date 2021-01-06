<?php

namespace App\Models;

use App\Traits\UseHash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use UseHash;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'borrowing_time',
        'return_time',
        'status',
        'key_id',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->first()->makeHidden('id');
    }
}
