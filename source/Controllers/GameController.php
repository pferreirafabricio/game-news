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

    /**
     * create
     *
     * @param  array $data
     * @return string
     */
    public function create(array $data): string
    {
        parse_str(file_get_contents('php://input'), $data);
        $gameObject = (object) $data;

        $this->game->title = $gameObject->title ?? null;
        $this->game->description = $gameObject->description ?? null;
        $this->game->video_id = $gameObject->video_id ?? null;

        if (!$this->game->required($data)) {
            return response([
                'message' => 'Verify the data and try again',
                'errcode' => 400
            ], 400)->json();
        }

        $errors = $this->validate($data);
        if ($errors) {
            return response([
                'message' => $errors,
                'errcode' => 400
            ], 400)->json();
        }

        /* if(is_null($this->game->create("games", $data) )) {
            return response([
                'message' => $this->game->fail()
            ])->json();
        }; */

        return response([
            'message' => 'Success! Game created successfully'
        ])->json();
    }
    
    /**
     * update
     *
     * @param  mixed $data
     * @return void
     */
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
    
    /**
     * validate
     *
     * @param  array $data
     * @param  bool $validateId
     * @return array
     */
    private function validate(array $data, bool $validateId = false): array
    {
        $errors = [];
        $game = $this->game->data();

        if ($validateId && $game->id <= 0) {
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
