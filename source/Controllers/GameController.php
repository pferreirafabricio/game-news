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
    public function index(array $data)
    {
        if (!$this->game->getAll()) {
            return response([
                'message' => $this->game->fail(),
            ])->json();
        }
        return response($this->game->getAll())->json();
    }
    
    /**
     * getById
     *
     * @param  mixed $data
     * @return string
     */
    public function getById(array $data): string
    {
        if (!$this->validateGameId($data['id'])) {
            return response([
                'message' => 'Oopss! The Id of the game is missing'
            ])->json();
        }
        
        return "The game id is: {$data['id']}";

        // $game = $this->game->findById($data['id'], "title, description, video_id");
        // return response($game)->json();
    }

    public function create(array $data)
    {
        parse_str(file_get_contents('php://input'), $data);
       
        if(!$this->game->create("games", $data)) {
            return response([
                'message' => $this->game->fail()
            ])->json();
        };

        return response([
            'message' => 'Success! Game created successfully'
        ])->json();
    }

    public function update(array $data)
    {
        if (!$this->validateGameId($data['id'])) {
            return response([
                'message' => 'Oopss! The Id of the game is missing'
            ])->json();
        }
        
        return "Update game id: {$data['id']}";
    }

    public function delete(array $data)
    {
        if (!$this->validateGameId($data['id'])) {
            return response([
                'message' => 'Oopss! The Id of the game is missing'
            ])->json();
        }

        return "Delete game id: {$data['id']}";
    }
    
    /**
     * validateGameId
     *
     * @param  mixed $id
     * @return bool
     */
    private function validateGameId($id): bool
    {
        if (empty($id)) {
            return false;
        }

        return true;
    }
}