<?php

namespace App\Facades;

use App\Payme\Payme as PaymePayme;
use Illuminate\Support\Facades\Facade;
use Illuminate\Http\Request;

class Payme extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PaymePayme::class;
    }
}
