<?php


namespace App\Repositories;


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

    public function list()
    {
        return parent::all()->makeHidden('id');
    }
}