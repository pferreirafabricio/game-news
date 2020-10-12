<?php

namespace Source\Interfaces;

interface iController
{
    public function index(array $data): string;
    public function create(): string;
    public function update(array $data): string;
    public function delete(array $data): string;
}
