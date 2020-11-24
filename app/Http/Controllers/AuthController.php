<?php


namespace App\Http\Controllers;


use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $auth;
    protected $input;
    protected $user;

    public function __construct(Request $request)
    {
        $this->auth = Auth::user();
        $this->input = $request;
        $this->user = new UserRepository();
    }

    public function register()
    {
        $this->validate($this->input, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        return $this->ok($this->user->register($this->input));
    }


    public function login(Request $request)
    {
        $this->validate($this->input, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ],
            ['email.required' => 'Preencha o email!',
                'password.required' => 'Preencha a senha!']);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user->makeHidden('id');

            $token = $user->createToken($user->email . '-' . now());

            return response()->json([
                'token' => $token->accessToken,
                'user' => $user
            ]);
        }
    }
}