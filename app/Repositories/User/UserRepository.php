<?php


namespace App\Repositories\User;


use App\Repositories\BaseRepository;
use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $payload): Model
    {
        $user = $this->model::create($payload);
        $role = new Role($payload);
        $user->role()->save($role);
        return $user;
    }

    public function getUser(string $email): ?User
    {
        return $this->model
            ->where('email', $email)
            ->first(['email']);
    }

    public function getUserByID($id): ?User
    {
        return $this->model
            ->with([
                'role' => function ($query) {
                    $query->select('id','type','user_id');
                }
            ])->find($id, ['id', 'name', 'email', 'phone']);
    }
}
