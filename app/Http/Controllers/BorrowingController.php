<?php


namespace App\Http\Controllers;


use App\Repositories\BorrowingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BorrowingController extends Controller
{
    protected $auth;
    protected $input;
    protected $borrowing;

    public function __construct(Request $request)
    {
        $this->auth = Auth::user();
        $this->input = $request;
        $this->borrowing = new BorrowingRepository();
    }

    public function borrowing($hash)
    {
        $request = new \Illuminate\Http\Request();

        $request->replace(['hash' => $hash]);

        $this->validate($request, [
            'hash' => [
                'required',
                Rule::exists('keys', 'hash')->where('availability', 'available'),
            ],
        ], ['hash.required' => 'Não encontramos a chave!',
            'hash.exists' => 'A chave está sendo usada!']);

        return $this->ok($this->borrowing->borrowing($hash, Auth::user()));
    }

    public function return($hash)
    {
        $request = new \Illuminate\Http\Request();

        $request->replace(['hash' => $hash]);

        $this->validate($request, [
            'hash' => [
                'required',
                Rule::exists('borrowings', 'hash'),
            ],
        ],
            ['hash.required' => 'Não encontramos o emprestimo!',
                'hash.exists' => 'Empréstimo não encontrado!']);

        return $this->ok($this->borrowing->return($hash));
    }
}