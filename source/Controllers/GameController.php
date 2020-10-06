<?php

namespace Source\Controllers;

use Source\Interfaces\iController;
use Source\Models\Game;

class GameController implements iController
{
    /** @var Game */
    private $game;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->game = new Game(); 
    }
    
    /**
     * index
     *
     * @return Game
     */
    public function index()
    {
        return response(["route" => "index"])->json();
    }
    
    /**
     * getById
     *
     * @param  mixed $data
     * @return string
     */
    public function getById(array $data): string
    {
        if (empty($data['id'] || ($data['id'] instanceof string))) {
            return response([
                'message' => 'Oopss! The Id of the game is missing'
            ])->json();
        }
        
        return "The game id is: {$data['id']}";

        // $game = $this->game->findById($data['id'], "title, description, video_id");
        // return response($game)->json();
    }

    public function create()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}