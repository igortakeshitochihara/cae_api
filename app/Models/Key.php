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

    public function borrowing()
    {
        $borrowing = $this->hasOne('App\Models\Borrowing', 'key_id', 'id')->where('status', 'open')
            ->first()->makeHidden('id');
        $borrowing->user = $borrowing->user();
        $borrowing->makeHidden('user_id', 'key_id');
        return $borrowing;
    }
}
