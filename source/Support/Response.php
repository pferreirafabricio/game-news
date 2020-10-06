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
     * @param array $data
     */
    public function __construct(array $data)
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
