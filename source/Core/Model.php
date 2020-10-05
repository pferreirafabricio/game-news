<?php

namespace Source\Core;

use stdClass;

class Model
{
    /** @var object|null Table data */
    protected $data;

    /** @var string Database table */
    protected static $entity;

    /** @var array Variables no update or create */
    protected static $protected;

    /** @var array Required fields */
    protected static $required;

    /**
     * __construct
     *
     * @param  string $entity Database table
     * @param  array $protected Variables no update or create
     * @param  array $required Required fields
     * @return void
     */
    public function __construct(string $entity, array $protected, array $required): void
    {
        $this->entity = $entity;
        $this->protected = $protected;
        $this->required = $required;
    }

    /**
     * __set
     *
     * @param  mixed $name
     * @param  mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new stdClass();
        }

        $this->data->$name = $value;
    }

    /**
     * __isset
     *
     * @param  mixed $name
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->data->$name);
    }

    /**
     * data
     *
     * @return object|null
     */
    public function data(): ?object
    {
        return $this->data;
    }

    public function create()
    {
    }

    public function read()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
    
    /**
     * Remove if a protected attribute is trying to be setted
     *
     * @return array|null
     */
    public function safe(): ?array
    {
        $safe = (array) $this->data;
        foreach (static::$protected as $unset) {
            unset($safe[$unset]);
        }

        return $safe;
    }
    
    /**
     * Verify if all required variables are present
     *
     * @return bool
     */
    public function required(): bool
    {
        $required = (array) $this->data;
        foreach(static::$required as $field) {
            if (empty($required[$field])) {
                return false;
            }
        }

        return true;
    }
}
