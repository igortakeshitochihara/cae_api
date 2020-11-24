<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class ServiceException extends Exception
{
    protected $data;

    public function __construct($message = '', array $data = null, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->data = $data;
    }

    final public function getData()
    {
        return $this->data;
    }
}