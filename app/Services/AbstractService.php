<?php

namespace App\Services;

abstract class AbstractService
{
    public static function make(): self
    {
        return app()->make(get_called_class());
    }
}
