<?php

namespace Source\Interfaces;

interface iController
{
    public function index(array $data);
    public function create(array $data);
    public function update(array $data);
    public function delete(array $data);
}
