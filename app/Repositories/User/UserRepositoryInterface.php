<?php


namespace App\Repositories\User;


use App\Repositories\RepositoryInterface;
use App\User;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getUser(string $email): ?User;
}
