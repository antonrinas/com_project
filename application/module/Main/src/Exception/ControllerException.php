<?php

namespace Main\Exception;

class ControllerException extends \Exception
{
    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
}