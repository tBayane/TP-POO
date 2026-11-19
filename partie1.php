<?php

class Personne
{
    // Attributs publics
    public string $nom;
    public string $prenom;

    // Attributs privés
    private string $dateNaissance;
    private string $villeNaissance;
    private string $cin;

    // Constructeur
    public function __construct(
        string $nom,
        string $prenom,
        string $dateNaissance,
        string $villeNaissance,
        string $cin
    ) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->villeNaissance = $villeNaissance;
        $this->cin = $cin;
    }

    // Méthode publique : retourne le nom complet
    public function getName(): string
    {
        return $this->prenom . " " . $this->nom;
    }

    // Méthode privée : calcule l'âge
    private function getAge(): int
    {
        $naissance = new DateTime($this->dateNaissance);
        $aujourdhui = new DateTime();

        return $naissance->diff($aujourdhui)->y;
    }
}


// Programme de test

$p = new Personne(
    "Hachimi",
    "Sara",
    "2000-05-14",
    "Marrakech",
    "EE123456"
);

// Test de getName()
echo "Nom complet : " . $p->getName() . "<br>";

// Accès à un attribut public
echo "Nom : " . $p->nom . "<br>";

// Les lignes suivantes provoquent une erreur
// car ces attributs et cette méthode sont privés.

// echo $p->cin;
// echo $p->dateNaissance;
// echo $p->getAge();

?>