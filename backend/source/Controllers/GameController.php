<?php

namespace Source\Controllers;

use Source\Interfaces\iController;
use Source\Models\Game;
use Source\Support\Request;

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
     * Get all games
     *
     * @param  array $data
     * @return void
     */
    public function index(array $data): string
    {         
        $games = $this->game->getAll();
        if ($this->game->fail()) {
            return response([
                'message' => $this->game->fail(),
            ], 500)->json();
        }

        return response($games)->json();
    }

    /**
     * Get a game by id
     *
     * @param  array $data
     * @return string
     */
    public function getById(array $data): string
    {
        $id = (int) $data['id'];
        
        if (!$this->validateGameId($id)) {
            return response([
                'message' => 'Oopss! The Id of the game is missing'
            ], 400)->json();
        }

        $game = $this->game->findById($id);
        if (is_null($game) || is_null($game->data())) {
            return response([
                'message' => "No game found with id {$id}"
            ], 404)->json();
        }

        return response($game->data())->json();
    }

    /**
     * Create a game
     * 
     * @return string
     */
    public function create(): string
    {
        $requestData = Request::decode(file_get_contents('php://input'));

        if (empty($requestData)) {
            return response([
                'message' => 'Oopss! The data to create is missing'
            ], 400)->json();
        }

        $this->game->bootstrap(
            $requestData['title'] ?? '',
            $requestData['description'] ?? '',
            $requestData['video_id'] ?? '',
        );

        if (!$this->game->required($requestData)) {
            return response([
                'message' => 'Verify the data and try again',
                'errcode' => 400
            ], 400)->json();
        }

        $errors = $this->validate();
        if ($errors) {
            return response([
                'message' => $errors,
                'errcode' => 400
            ], 400)->json();
        }

        $insertedId =  $this->game->create($requestData);
        if($this->game->fail()) {
            return response([
                'message' => $this->game->fail()
            ])->json();
        };

        return response([
            'gameId' => $insertedId,
            'message' => 'Success! Game created successfully'
        ])->json();
    }
    
    /**
     * Update a game by id
     *
     * @param  array $data
     * @return string
     */
    public function update(array $data): string
    {
        $requestData = Request::decode(file_get_contents('php://input'));

        if (empty($requestData)) {
            return response([
                'message' => 'Oopss! The data to update is missing'
            ], 400)->json();
        }

        $id = (int) $data['id'] ?? 0;

        if (!$this->validateGameId($id)) {
            return response([
                'message' => 'Oopss! The Id of the game is missing'
            ], 400)->json();
        }

        $this->game->bootstrap(
            $requestData['title'] ?? '',
            $requestData['description'] ?? '',
            $requestData['video_id'] ?? '',
        );

        if (!$this->game->required($requestData)) {
            return response([
                'message' => 'Verify the data and try again',
                'errcode' => 400
            ], 400)->json();
        }

        $errors = $this->validate(true, $id);
        if ($errors) {
            return response([
                'message' => $errors,
                'errcode' => 400
            ], 400)->json();
        }

        if (!$this->game->updateById($requestData, $id)) {
            return response([
                'message' => 'Oopss! Something was wrong on update the game',
            ], 500)->json();
        }

        return response([
            'message' => 'Success! Game updated',
        ])->json();
    }
    
    /**
     * Delete a game by id
     *
     * @param  array $data
     * @return string
     */
    public function delete(array $data): string
    {
        $id = (int) $data['id'] ?? 0;

        if (!$this->validateGameId($id)) {
            return response([
                'message' => 'Oopss! The Id of the game is missing'
            ], 400)->json();
        }

        if (!$this->game->remove($id)) {
            return response([
                'message' => 'Oopss! Something was wrong on update the game',
            ], 500)->json();
        }

        return response([
            'message' => 'Success! Game deleted',
        ], 200)->json();
    }

    /**
     * Verify if a game id is valid
     *
     * @param  int $id
     * @return bool
     */
    private function validateGameId(int $id): bool
    {
        if (is_null($id) || $id <= 0) {
            return false;
        }

        return true;
    }
    
    /**
     * Valida the basic data of the game
     *
     * @param  bool $validateId
     * @param  int $id
     * @return array
     */
    private function validate(bool $validateId = false, int $id = 0): array
    {
        $errors = [];
        $game = $this->game->data();

        if ($validateId && $id <= 0) {
            $errors[] = 'The id of the game is invalid';
        }

        if (strlen($game->title) < 4 || strlen($game->title) > 100) {
            $errors[] = 'The title of the game is invalid';
        }

        if (strlen($game->description) < 10 || strlen($game->description) > 255) {
            $errors[] = 'The description of the game is invalid';
        }

        if (empty($game->video_id) || strlen($game->video_id) <= 8) {
            $errors[] = 'The video id of the game is invalid';
        }

        return $errors;
    }
}
