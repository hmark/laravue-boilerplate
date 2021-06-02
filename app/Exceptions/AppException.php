<?php

namespace App\Exceptions;

use App\Enums\Error;

class AppException extends \Exception

{
    public $data;
    public $type;

    public function __construct(Error $type, $data = [])
    {
        $this->type = $type;
        $this->data = $data;

        parent::__construct();
    }
}
