<?php


namespace App\Repositories;


use App\Models\Borrowing;
use App\Models\Key;
use DateTime;

class BorrowingRepository extends BaseRepository
{
    protected $model;
    protected $key;

    public function __construct()
    {
        $this->model = new Borrowing();
        $this->key = new Key();
        parent::__construct($this->model);
    }

    public function borrowing($hash, $user)
    {
        $key = $this->key->where('hash', $hash)->first();
        parent::create([
            'borrowing_time' => new DateTime(),
            'key_id' => $key->id,
            'user_id' => $user->id
        ]);
        // update availability key
        $key->update([
            'id' => $key->id,
            'availability' => 'unavailable'
        ]);
        return ['message' => 'Emprestiomo aberto com sucesso'];
    }

    public function return($hash)
    {
        $borrowing = $this->model->where('hash', $hash)->first();
        $key = $this->key->find($borrowing->key_id);
        $borrowing->update([
            'id' => $borrowing->id,
            'return_time' => new DateTime(),
            'status' => 'closed'
        ]);
        // update availability key
        $key->update([
            'id' => $key->id,
            'availability' => 'available'
        ]);
        return ['message' => 'Emprestiomo fechado com sucesso'];
    }
}