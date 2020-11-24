<?php


namespace App\Repositories;


use App\Models\User;

class UserRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
        parent::__construct($this->model);
    }

    public function register($request)
    {
        $user = parent::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => $request->type
        ]);

        // hidden id
        $user->makeHidden('id');

        // create token for user
        $token = $user->createToken($user->email . '-' . now());

        return [
            'token' => $token->accessToken,
            'user' => $user
        ];
    }

    public function login($request)
    {

    }
}