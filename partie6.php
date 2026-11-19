<?php


// 6.1 - Héritage avec Animal et Chien

class Animal
{
    public function manger(): void
    {
        echo "L'animal mange.<br>";
    }
}

class Chien extends Animal
{
    public function aboyer(): void
    {
        echo "Le chien aboie : Wouf Wouf !<br>";
    }
}

class Chat extends Animal
{
    public function miauler(): void
    {
        echo "Le chat miaule : Miaou !<br>";
    }
}

echo "<h3>6.1 - Animal, Chien et Chat</h3>";

$c = new Chien();
$c->manger();
$c->aboyer();

$chat = new Chat();
$chat->manger();
$chat->miauler();


// 6.2 - parent:: et héritage


class Personne
{
    protected string $nom;
    protected string $prenom;
    private string $dateNaissance;
    private string $villeNaissance;
    private string $cin;

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

    public function presentation(): string
    {
        return "Nom : " . $this->nom;
    }

    // protected permet à la classe fille de l'utiliser
    protected function getAge(): int
    {
        $naissance = new DateTime($this->dateNaissance);
        $aujourdhui = new DateTime();

        return $naissance->diff($aujourdhui)->y;
    }

    public function __toString(): string
    {
        return $this->prenom . " " . $this->nom .
               " (" . $this->getAge() . " ans)";
    }
}

class Etudiant extends Personne
{
    private string $cne;

    public function __construct(
        string $nom,
        string $prenom,
        string $dateNaissance,
        string $villeNaissance,
        string $cin,
        string $cne
    ) {
        parent::__construct(
            $nom,
            $prenom,
            $dateNaissance,
            $villeNaissance,
            $cin
        );

        $this->cne = $cne;
    }

    public function getCne(): string
    {
        return $this->cne;
    }

    public function __toString(): string
    {
        return parent::__toString() . " - CNE : " . $this->getCne();
    }
}



// 6.3 - final et readonly


class Base
{
    final public function afficher(): void
    {
        echo "Méthode finale : elle ne peut pas être redéfinie.<br>";
    }
}

class Fille extends Base
{
    // On ne peut pas redéfinir afficher() car elle est final.
}

final class Outil
{
    public readonly string $reference;

    public function __construct(string $reference)
    {
        $this->reference = $reference;
    }
}