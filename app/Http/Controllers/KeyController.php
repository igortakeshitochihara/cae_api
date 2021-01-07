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

    public function update()
    {
        $this->validate($this->input, [
            'name' => 'required',
            'hash' => [
                'required',
                Rule::exists('keys', 'hash')
            ],
            'room_id' => [
                'required',
                Rule::exists('rooms', 'hash')
            ],
        ]);

        return $this->ok($this->key->update($this->input));
    }

    public function list()
    {
        return $this->ok($this->key->list());
    }

    public function remove($hash) {
        $request = new \Illuminate\Http\Request();

        $request->replace(['hash' => $hash]);

        $this->validate($request, [
            'hash' => [
                'required',
                Rule::exists('keys', 'hash')
                    ->where('availability', 'available'),
            ],
        ], ['hash.required' => 'Não encontramos a chave!',
            'hash.exists' => 'A chave está sendo usada!']);
        return $this->ok($this->key->remove($hash));
    }
}