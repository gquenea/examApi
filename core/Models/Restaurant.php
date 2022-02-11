<?php

namespace Models;

use JsonSerializable;

class Restaurant extends AbstractModel implements JsonSerializable
{

    protected string $nomDeLaTable = "restaurants";

    protected $id;
    protected $nom;
    protected $adresse;
    protected $ville;

    public function getId()
    {
        return $this->id;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    public function getAdresse()
    {
        return $this->adresse;
    }
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }
    public function getVille()
    {
        return $this->ville;
    }
    public function setVille($ville)
    {
        $this->ville = $ville;
    }


    /**
     * Permet de sérialiser les données
     *
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->id,
            "nom" => $this->nom,
            "adresse" => $this->adresse,
            "ville" => $this->ville,
            "plat" => $this->getPlat()
        ];
    }
    /**
     * sauvegarde les restaurants créés dans la bdd
     *
     * @param Restaurant $restaurant
     * @return void
     */
    public function save(Restaurant $restaurant)
    {
        $sql = $this->pdo->prepare("INSERT INTO {$this->nomDeLaTable} (nom, adresse, ville) VALUES (:nom, :adresse, :ville)");
        $sql->execute([
            "nom" => $restaurant->nom,
            "adresse" => $restaurant->adresse,
            "ville" => $restaurant->ville
        ]);
    }


    /**
     * Permet de récuperer un plat
     *
     * @return array | bool
     */
    public function getPlat()
    {

        $modelPlat = new \Models\Plat();
        return $modelPlat->findAllByRestaurant($this);
    }
}
