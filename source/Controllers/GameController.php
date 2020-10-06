<?php

namespace Source\Controllers;

use Source\Models\Game;

class GameController 
{
    /** @var Game */
    private $game;

    // public function __construct(string $title, string $description, string $videoId)
    // {
    //     $this->game = (new Game())->bootstrap($title, $description, $videoId); 
    // }
    
    /**
     * index
     *
     * @return Game
     */
    public function index()
    {
        return json_encode(["route" => "index"]);
    }
}