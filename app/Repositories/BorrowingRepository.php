<?php


namespace App\Repositories;


use App\Models\Borrowing;

class BorrowingRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Borrowing();
        parent::__construct($this->model);
    }

    public function borrowing()
    {

    }

    public function return()
    {

    }
}