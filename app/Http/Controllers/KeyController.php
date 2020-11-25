<?php


namespace App\Http\Controllers;


use App\Repositories\KeyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class KeyController extends Controller
{
    protected $auth;
    protected $input;
    protected $key;

    public function __construct(Request $request)
    {
        $this->auth = Auth::user();
        $this->input = $request;
        $this->key = new KeyRepository();
    }

    public function add()
    {
        $this->validate($this->input, [
            'name' => 'required',
            'room_id' => [
                'required',
                Rule::exists('rooms', 'hash')
            ],
        ]);

        return $this->ok($this->key->add($this->input));
    }

    public function list()
    {
        return $this->ok($this->key->list());
    }
}