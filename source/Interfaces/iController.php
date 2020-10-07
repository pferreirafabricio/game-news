<?php

namespace Source\Interfaces;

interface iController
{
    public function index(array $data);
    public function create();
    public function update(array $data);
    public function delete(array $data);
}
