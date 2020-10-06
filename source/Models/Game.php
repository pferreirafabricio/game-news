<?php

namespace Source\Models;

use Source\Core\Model;

class Game extends Model
{    
    /**
     * Game constructor
     *
     * @return void
     */
    public function __construct()
    {   
        parent::__construct("game", ["id"], ["title", "description", "videoId"]);
    }
    
    /**
     * bootstrap
     *
     * @param  string $title
     * @param  string $description
     * @param  string $videoId
     * @return Game
     */
    public function bootstrap(string $title, string $description, string $videoId): Game
    {
        $this->title = $title;
        $this->description = $description;
        $this->videoId = $videoId;
        return $this;
    }
    
    /**
     * Generic method for find record(s)
     *
     * @param  string $terms
     * @param  string $params
     * @param  string $columns
     * @return void
     */
    public function find(string $terms, string $params, string $columns = "*"): ?Game
    {
        $find = $this->read("SELECT {$columns } FROM " . self::$entity . " WHERE {$terms}", $params);
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }

        return $find->fetchObject(__CLASS__);
    }
    
    /**
     * Get all records
     *
     * @return Game
     */
    public function getAll(): ?Game
    {
        return $this->find("id >= :id", "id=1");
    }
    
    /**
     * Find a game by Id
     *
     * @param  int $id
     * @param  string $columns
     * @return Game
     */
    public function findById(int $id, string $columns = "*"): ?Game
    {
        return $this->find("id = :id", "id={$id}", $columns);
    }
        
    /**
     * Find a game by title
     *
     * @param  string $title
     * @param  string $columns
     * @return void
     */
    public function findByTitle(string $title, string $columns = "*")
    {
        return $this->find("title = :title", "title={$title}", $columns);
    }
}