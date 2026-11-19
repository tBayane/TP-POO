<?php
class Voiture {
    public function __construct(
        public string $couleur = "Blanche",
        public int $vitesse = 0
    ) {
        echo "Voiture {$this->couleur} créée." . PHP_EOL;
    }

    public function afficher(): void {
        echo "Couleur : {$this->couleur} | Vitesse : {$this->vitesse} km/h" . PHP_EOL;
    }

    public function __destruct() {
        echo "Voiture {$this->couleur} détruite." . PHP_EOL;
    }
}

$v1 = new Voiture("Noire", 50);
$v1->afficher();