<?php


namespace App\Http\Controllers;


use App\Repositories\BorrowingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    }

    public function return($hash)
    {

    }
}