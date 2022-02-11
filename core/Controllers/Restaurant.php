<?php

namespace Controllers;

class Restaurant extends AbstractController
{

    protected $defaultModelName = \Models\Restaurant::class;

    public function index()
    {
        return $this->json($this->defaultModel->findAll());
    }


    /**
     * Verifie si els conditions sont remplis afin d'effectuer une sauvegarde d'un restaurant
     *
     * @return string
     */
    public function new()
    {

        $request = $this->post('json', ['nom' => 'text', 'adresse' => 'text', 'ville' => 'text']);

        if (!$request) {
            return $this->json("formulaire mal rempli");
        }

        $restaurant = new \Models\Restaurant();
        $restaurant->setNom($request['nom']);
        $restaurant->setAdresse($request['adresse']);
        $restaurant->setVille($request['ville']);
        $this->defaultModel->save($restaurant);

        return $this->json("Le restaurant bien créée");
    }


    /**
     * Verifie si els conditions sont remplis afin d'effectuer une suppression d'un restaurant
     *
     * @return string
     */
    public function suppr()
    {

        $request = $this->delete('json', ['id' => 'number']);
        if (!$request) {
            return $this->json("Requete mal soumise", "delete");
        }

        $restaurant = $this->defaultModel->findById($request['id']);
        if (!$restaurant) {
            return $this->json("Cette restaurant n'existe pas");
        }

        $this->defaultModel->remove($restaurant);
        return $this->json("Bien supprimé", "delete");
    }
}
