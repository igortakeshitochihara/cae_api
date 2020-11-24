<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($data)
    {
        $_model = $this->model->find($data['id']);
        $_model->update($data);
        return $_model;
    }

    public function delete($id)
    {
        if ($this->model->destroy($id) != 0) {
            return ['message' => 'Removido com Sucesso!'];
        }
        return '';
    }

    public function show($id, $select = null, $with = null)
    {
        $result = $this->model->where('id', $id);
        if (isset($with))
            $result->with($with);
        if (isset($select))
            $result->select($select);
        return $result->first();
    }
}
