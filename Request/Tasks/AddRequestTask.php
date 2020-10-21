<?php

namespace App\Ship\App\Request\Tasks\Events\Requests;

use App\Ship\App\Request\Enums\RequestStatusEnum;
use App\Ship\App\Request\Interfaces\RequestParametersInterface;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class AddRequestTask extends Task
{

    /**
     * @param Repository $repository
     * @param RequestParametersInterface $parameters
     * @return mixed
     */
    public function run(Repository $repository, RequestParametersInterface $parameters)
    {
        try {
            return $repository->create($parameters->forCreate());
        } catch (Exception $exception) {
            throw (new CreateResourceFailedException())->debug($exception);
        }
    }

}
