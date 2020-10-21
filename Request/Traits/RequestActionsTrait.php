<?php


namespace App\Ship\App\Request\Traits;

use App\Ship\App\Request\Enums\RequestStatusEnum;
use Illuminate\Support\Facades\DB;

/**
 * Доп. класс для класса репозиториев
 * Trait RequestActionsTrait
 * @package App\Ship\App\Request\Traits
 */
trait RequestActionsTrait
{
    /**
     * FIXME: вынести в отдельные методы обновления
     * Обновление статуса и даты исключения
     * @param int $mid
     * @param array $users
     * @param int $status
     * @param bool $deviation
     * @return int
     */
    public function updateStatusAndDeviation(int $mid, array $users, int $status, bool $deviation)
    {
        $data = ['status' => $status];

        if ($deviation) {
            $data['deviation_at'] = now();
        }

        $query = DB::table($this->model->getTable());

        // если согласование - то только те которые ожыдают согласования
        if ($status === RequestStatusEnum::ACCEPT_STATUS) {
            $query->where('status', RequestStatusEnum::WAITING_STATUS);
        }

        // если отклонить - то только те которые ожыдают согласования и те которые согласованы
        if ($status === RequestStatusEnum::REJECT_STATUS) {
            $query->where(function ($q) {
                $q->where('status', RequestStatusEnum::WAITING_STATUS)
                    ->orWhere('status', RequestStatusEnum::ACCEPT_STATUS);
            });
        }

        // если восстановить - то только те которые отклонены
        if ($status === RequestStatusEnum::WAITING_STATUS) {
            $query->where('status', RequestStatusEnum::REJECT_STATUS);
        }

        return $query->where('element_id', $mid)->whereIn('tabnr', $users)->update($data);
    }

    /**
     * FIXME: удалить, использовать scopeQuery
     * @param string $column
     * @param string $value
     * @param string $criteriaField
     * @param array $criteriaValue
     * @return mixed
     */
    public function deleteByCriteria(string $column, string $value, string $criteriaField, array $criteriaValue)
    {
        $this->applyScope();
        $this->applyCriteria();

        return $this->model->where($column, $value)->whereIn($criteriaField, $criteriaValue)->delete();
    }
}
