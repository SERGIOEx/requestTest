<?php

namespace App\Ship\App\Request\Tasks\Events\Requests;

use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Parents\Tasks\Task;

class ChangeStatusByIdsTask extends Task
{

    /**
     * @param Repository $repository
     * @param int $eid
     * @param array $users
     * @param int $status
     * @param bool $deviation
     * @return mixed
     */
    public function run(Repository $repository, int $eid, array $users, int $status, bool $deviation = false)
    {
        $result = $repository->updateStatusAndDeviation($eid, $users, $status, $deviation);

        // TODO: убрать exception для фронта
        if ($result === 0) {
            throw new ValidationFailedException('Change Status: Data is Empty.', [], 400, 10001);
        }

        return;
    }

}
