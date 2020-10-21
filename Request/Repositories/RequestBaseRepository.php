<?php


namespace App\Ship\App\Request\Repositories;


use App\Ship\App\Request\Traits\RequestActionsTrait;
use App\Ship\Parents\Repositories\Repository;

class RequestBaseRepository extends Repository
{
    use RequestActionsTrait;
}
