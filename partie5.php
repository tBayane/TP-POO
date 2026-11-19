<?php

class Utilisateur
{
    private string $nom;
    private int $age;
    private string $motDePasse;

    public function __construct(string $nom, int $age, string $motDePasse)
    {
        $this->nom = $nom;
        $this->age = $age;
        $this->motDePasse = $motDePasse;
    }

    // Choisir les données à sérialiser
    public function __serialize(): array
    {
        return [
            'nom' => $this->nom,
            'age' => $this->age
            // Le mot de passe est volontairement exclu
        ];
    }

    // Reconstruire l'objet après désérialisation
    public function __unserialize(array $data): void
    {
        $this->nom = $data['nom'];
        $this->age = $data['age'];
        $this->motDePasse = "";
    }
}

// Création d'un utilisateur
$u = new Utilisateur("Alice", 25, "secret123");

// Sérialisation
$serialise = serialize($u);

echo "<h3>Objet sérialisé :</h3>";
echo "<pre>";
echo htmlspecialchars($serialise);
echo "</pre>";

// Désérialisation
$restaure = unserialize($serialise);

echo "<h3>Objet restauré :</h3>";
echo "<pre>";
var_dump($restaure);
echo "</pre>";

?>