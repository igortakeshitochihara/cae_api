<?php


namespace App\Http\Controllers;


use App\Repositories\RoomRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

    public function update()
    {
        $this->validate($this->input, [
            'name' => 'required',
            'hash' => [
                'required',
                Rule::exists('rooms', 'hash')
            ],
        ]);

        return $this->ok($this->room->update($this->input));
    }

    public function list()
    {
        return $this->ok($this->room->list());
    }

    public function remove($hash) {
        $request = new \Illuminate\Http\Request();

        $request->replace(['hash' => $hash]);

        $this->validate($request, [
            'hash' => [
                'required',
                Rule::exists('rooms', 'hash'),
            ],
        ], ['hash.required' => 'Não encontramos a sala!',
            'hash.exists' => 'Não encontramos a sala!']);
        return $this->ok($this->room->remove($hash));
    }
}