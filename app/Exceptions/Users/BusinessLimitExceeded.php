<?php

namespace App\Exceptions\Users;

use Exception;

class BusinessLimitExceeded extends Exception
{
    protected $message = 'User has reached business limit.';
}
