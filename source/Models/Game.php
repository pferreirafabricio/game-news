<?php

namespace Source\Models;

use Source\Core\Model;

class Game extends Model
{
    private $id;
    private $title;
    private $description;
    private $videoId;

    public function bootstrap(string $title, string $description, string $videoId): Game
    {
        $this->title = $title;
        $this->description = $description;
        $this->videoId = $videoId;
        return $this;
    }
}