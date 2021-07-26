<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface
{
    protected $model;

    /**
     * BaseRepository constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function create(array $payload): Model
    {
        $model = $this->model->create($payload);
        return $model->fresh();
    }


    public function findById(int $modelId,
                             array $columns = ['*'],
                             array $relations = [],
                             array $appends = []): ?Model
    {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }
}
