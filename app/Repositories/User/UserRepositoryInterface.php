<?php


namespace App\Repositories\User;


use App\User;
use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getUser(string $email) :?User;
}
