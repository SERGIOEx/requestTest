<?php


namespace App\Ship\App\Request\Validations;


use App\Ship\App\Request\Enums\RequestStatusEnum;
use App\Ship\Exceptions\ValidationFailedException;

/**
 * Базовый класс валидации сущности по заявкам
 * Class BaseRequestValidation
 * @package App\Ship\App\Request\Validations
 */
class BaseRequestValidation
{

    /**
     * Ошибка - данные не валидные
     */
    protected function errorDataIsNotValid()
    {
        $this->failedResponse('Data is not valid.', 10000);
    }

    /**
     * Ошибка - данные пустые
     */
    protected function errorDataIsEmpty()
    {
        $this->failedResponse('Data is Empty.', 10001);
    }

    /**
     * Ошибка - только уволленые сотрудники
     */
    protected function errorOnlyDismissedEmployees()
    {
        $this->failedResponse('Removal - Only Dismissed Employees.', 10002);
    }

    /**
     * Ошибка - нужна регистрация через заявку
     * @param int $need_reg
     */
    protected function errorNeedRegistered(int $need_reg)
    {
        if ($need_reg !== false) {
            $this->failedResponse('You can only register for an element by submitting an application.', 10003);
        }
    }

    /**
     * Ошибка - статус не открыт для регистрации
     * @param int $status
     */
    protected function errorNotOpened(int $status)
    {
        if ($status === false) {
            $this->failedResponse('Element status - not open.', 10004);
        }
    }

    /**
     * Ошибка - заявка обработана
     * @param int $status
     */
    protected function errorRequestHasUpdate(int $status)
    {
        if (RequestStatusEnum::WAITING_STATUS !== $status) {
            $this->failedResponse('Request has been updated.', 10006);
        }
    }

    /**
     * Проверка свитчера - "Требуется регистрация"
     * @param $data
     */
    protected function errorNeedRegistration($data)
    {
        if (empty($data) || $data === false) {
            $this->failedResponse('Need setting - \'Registration required\'.', 10007);
        }
    }

    /**
     * Ошибка - пользователь уже зарегистрирован
     * @param $data
     * @param string $message
     * @param int $code
     */
    protected function errorEduExist($data, string $message = 'User already registered', int $code = 1011)
    {
        if ($data) {
            $this->failedResponse($message, $code);
        }
    }

    /**
     * TODO: параметры вынести по отдельности
     * Проверка валидности дат сущности
     * @param $parameters
     */
    protected function checkValidElementDates($parameters)
    {

        // даты старта и окончания
        if ($parameters->date_end) {
            if ($parameters->date_start > $parameters->date_end) {
                $this->failedResponse('Start\End date error', 10014);
            }
        }

        // даты периода регистрации
        if ($parameters->required_reg && $parameters->period_end) {
            if ($parameters->period_start > $parameters->period_end) {
                $this->failedResponse('Registration period date error', 10015);
            }
        }

    }

    /**
     * Проверка макс. количество элементов из группы
     * @param $max_elements
     * @param $current_cnt
     */
    protected function checkMaxElementsInGroup(int $max_elements, int $current_cnt)
    {
        if ($current_cnt >= $max_elements) {
            $this->failedResponse('Achieved max. number of elements from the group', 10019);
        }
    }


    /**
     * Проверка валидности дат при создании/редактировании сущности
     * @param string $entity_date_end
     * @param string $date_now
     */
    protected function checkDates(string $entity_date_end, string $date_now)
    {
        if ($entity_date_end <= $date_now) { // завершено или не начато
            $this->failedResponse('End date error', 10014);
        }
    }

    /**
     * Проверка макс. числа участников
     * @param int $max_count
     * @param int $curr_count
     */
    protected function checkMaxUsers(?int $max_count, int $curr_count)
    {
        if ($max_count === 0 || $curr_count > $max_count) {
            $this->failedResponse('Maximum number of participants reached', 10017);
        }
    }

    /**
     * Кастомный ответ ошибки
     * ValidationFailedException
     * @param string $message
     * @param int $code
     */
    private function failedResponse(string $message, int $code = 0): void
    {
        throw new ValidationFailedException($message, [], 400, $code);
    }
}
