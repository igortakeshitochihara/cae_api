<?php


namespace App\Http\Controllers;


use App\Repositories\RoomRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    protected $auth;
    protected $input;
    protected $room;

    public function __construct(Request $request)
    {
        $this->auth = Auth::user();
        $this->input = $request;
        $this->room = new RoomRepository();
    }

    public function add()
    {
        $this->validate($this->input, [
            'name' => 'required',
        ]);

        return $this->ok($this->room->add($this->input));
    }

    public function list()
    {
        return $this->ok($this->room->list());
    }
}