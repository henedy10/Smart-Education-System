<?php

namespace App\Traits;

trait UserHelper
{
    public function getUserId()
    {
        return session('id');
    }
}
