<?php

namespace Source\Support;

use Source\Interfaces\iResponsable;

class Response implements iResponsable
{
    /** @var array */
    private $data; 

    /**
     * __construct
     *
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        return $this;
    }
    
    /**
     * Return the given data as JSON
     *
     * @return string
     */
    public function json(): string
    {
        return (json_encode($this->data) ?? '');
    }
}
