<?php


namespace App\Ship\App\Request\Enums;


final class RequestStatusEnum
{
    // статус
    public const WAITING_STATUS = 0; // Ожидает согласования
    public const ACCEPT_STATUS = 1; // Заявка согласована
    public const REJECT_STATUS = 2; // Отклонена
}
