<?php


namespace App\Repositories;


use App\Exceptions\ServiceException;
use App\Models\Room;

class RoomRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Room();
        parent::__construct($this->model);
    }

    public function add($request)
    {
        parent::create([
            'name' => $request->name,
        ]);
        return ['message' => 'Sala adicionado com sucesso'];
    }

    public function update($request)
    {
        $room = $this->model->where('hash', $request['hash'])->first();
        parent::update([
            'id' => $room->id,
            'name' => $request->name,
        ]);
        return ['message' => 'Sala alterado com sucesso'];
    }

    public function list()
    {
        return parent::all()->makeHidden('id');
    }

    public function remove($hash)
    {
        $room = $this->model->where('hash', $hash)->first();
        if($room->keysUnavailable()->count() != 0)
            throw new ServiceException('A sala possuem chaves em uso!');
        foreach ($room->keys() as $key)
            $key->delete();
        $room->delete();
        return ['message' => 'Sala removido com sucesso'];
    }
}