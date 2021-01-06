<?php


namespace App\Repositories;


use App\Models\Key;
use App\Models\Room;

class KeyRepository extends BaseRepository
{
    protected $model;
    protected $room;

    public function __construct()
    {
        $this->model = new Key();
        $this->room = new Room();
        parent::__construct($this->model);
    }

    public function add($request)
    {
        $room = $this->room->where('hash', $request['room_id'])->first();
        parent::create([
            'name' => $request->name,
            'room_id' => $room->id
        ]);
        return ['message' => 'Chave adicionado com sucesso'];
    }

    public function update($request)
    {
        $room = $this->room->where('hash', $request['room_id'])->first();
        $key = $this->model->where('hash', $request['hash'])->first();
        parent::update([
            'id' => $key->id,
            'name' => $request->name,
            'room_id' => $room->id
        ]);
        return ['message' => 'Chave alterado com sucesso'];
    }

    public function list()
    {
        return parent::all()->map(function ($query) {
            $query->room = $query->room();
            if ($query->availability == 'unavailable')
                $query->borrowing = $query->borrowing();
            return $query;
        })->makeHidden(['id', 'room_id']);
    }

    public function remove($hash)
    {
        $key = $this->model->where('hash', $hash)->first();
        $key->delete();
        return ['message' => 'Chave removido com sucesso'];
    }
}