<?php

namespace Models;

use JsonSerializable;

class Plat extends AbstractModel implements JsonSerializable
{


    protected string $nomDeLaTable = "plats";

    private $id;
    private $description;
    private $prix;
    private $restaurant_id;

    public function getId()
    {
        return $this->id;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getPrix()
    {
        return $this->prix;
    }
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }
    public function getRestaurantId()
    {
        return $this->restaurant_id;
    }
    public function setRestaurantId($restaurant_id)
    {
        $this->restaurant_id = $restaurant_id;
    }


    /**
     * Permet de sérialiser les données
     *
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        return [
            "description" => $this->description,
            "prix" => $this->prix,
            "restaurant_id" => $this->restaurant_id,

        ];
    }


    /**
     * Permet de recupérer les données d'un plat via l'id d'un restaurant
     *
     * @return $restaurant
     */
    public function findAllByRestaurant(Restaurant $restaurant)
    {
        $sql = $this->pdo->prepare("SELECT * FROM {$this->nomDeLaTable}
            WHERE restaurant_id = :restaurant_id
        ");

        $sql->execute([
            "restaurant_id" => $restaurant->getId()
        ]);

        $restaurant = $sql->fetchAll(\PDO::FETCH_CLASS, get_class($this));

        return $restaurant;
    }
}
