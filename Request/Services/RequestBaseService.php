<?php


namespace App\Ship\App\Request\Services;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\App\Request\Interfaces\RequestParametersInterface;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\App\Request\Tasks\AddRequestTask;
use App\Ship\App\Request\Tasks\ChangeStatusByIdsTask;
use App\Ship\App\Request\Tasks\DeleteRequestsTask;

class RequestBaseService
{

    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Добавить заявку
     * @param RequestParametersInterface $parameters
     * @return mixed
     */
    public function addRequest(RequestParametersInterface $parameters)
    {
        return Apiato::call(AddRequestTask::class, [$this->repository, $parameters]);
    }

    /**
     * Снять(отклонить свою активную) заявку
     * @param int $eid
     * @param int $uid
     * @return mixed
     */
    public function rejectMyRequest(int $eid, int $uid)
    {
       // TODO
    }

    /**
     * Получить список заявок пользователей
     * @return mixed
     */
    public function getAllByParameters()
    {
        // TODO
    }

    /**
     * Изменить статус заявок пользователей
     * @param int $eid
     * @param array $users
     * @param int $status
     * @param bool $deviation
     * @return
     */
    public function changeStatusRequests(int $eid, array $users, int $status, bool $deviation = false)
    {
        return Apiato::call(ChangeStatusByIdsTask::class, [
            $this->repository, $eid, $users, $status, $deviation
        ]);
    }

    /**
     * Удалить заявки пользователей
     * @param int $eid
     * @param array $users
     * @return
     */
    public function deleteRequests(int $eid, array $users)
    {
        return Apiato::call(DeleteRequestsTask::class, [$this->repository, $eid, $users]);
    }

}
