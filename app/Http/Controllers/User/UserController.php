<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getEmployeeProfile(Request $request){
        $id = Auth::id();
        $user = $this->userRepository->getUserByID($id);
        if($user){
            return response() -> json($user);
        }

        return response() -> json(["error"=>"User not found"]);
    }
}
