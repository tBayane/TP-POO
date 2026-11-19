<?php

class Personne
{
    private string $nom;
    private string $prenom;
    private string $dateNaissance;
    private string $villeNaissance;
    private string $cin;

    private array $extra = [];

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

    // Méthode magique __set()
    public function __set(string $name, mixed $value): void
    {
        if ($name === "nom") {
            if (!is_string($value)) {
                throw new InvalidArgumentException("Nom invalide");
            }

            $value = trim($value);

            if ($value === "" || strlen($value) < 2) {
                throw new InvalidArgumentException("Le nom doit contenir au moins 2 caractères.");
            }

            $this->nom = $value;
        } elseif (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            $this->extra[$name] = $value;
        }
    }

    // Méthode magique __get()
    public function __get(string $name): mixed
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        if (array_key_exists($name, $this->extra)) {
            return $this->extra[$name];
        }

        return null;
    }

    // Méthode magique __isset()
    public function __isset(string $name): bool
    {
        if (property_exists($this, $name)) {
            return isset($this->$name);
        }

        return isset($this->extra[$name]);
    }

    // Méthode magique __unset()
    public function __unset(string $name): void
    {
        if (property_exists($this, $name)) {
            unset($this->$name);
        } else {
            unset($this->extra[$name]);
        }
    }
}

// Création d'un objet
$p = new Personne(
    "Hachimi",
    "Sara",
    "2000-05-14",
    "Marrakech",
    "EE123456"
);

// Test de __set() et __get()
$p->nom = "Hachimi";
echo "Nom : " . $p->nom . "<br>";

// Test de __isset()
var_dump(isset($p->nom));
echo "<br>";

// Test de __unset()
unset($p->nom);
var_dump(isset($p->nom));
echo "<br>";

// Test d'une propriété supplémentaire
$p->telephone = "0600000000";
echo "Téléphone : " . $p->telephone;

?>