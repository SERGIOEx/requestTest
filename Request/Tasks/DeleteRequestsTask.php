<?php

namespace App\Ship\App\Request\Tasks\Events\Requests;

use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Parents\Tasks\Task;

class DeleteRequestsTask extends Task
{

    /**
     * @param Repository $repository
     * @param string $column
     * @param string $value
     * @param string $criteriaField
     * @param array $criteriaValue
     * @return mixed
     */
    public function run(Repository $repository, string $column, string $value, string $criteriaField, array $criteriaValue)
    {
        try {
            return $repository->deleteByCriteria($column, $value, $criteriaField, $criteriaValue);
        } catch (\Exception $exception) {
            throw (new DeleteResourceFailedException())->debug($exception);
        }
    }

}
