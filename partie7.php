<?php

class Compte
{
    private float $montant;
    private float $interet;

    // Constructeur
    public function __construct(float $montantInitial, float $interet)
    {
        $this->montant = $montantInitial;
        $this->interet = $interet;
    }

    // Retourner le montant du compte
    public function get_montant(): float
    {
        return $this->montant;
    }

    // Calculer les intérêts après une année
    public function un_an(): void
    {
        $this->montant = $this->montant * (1 + $this->interet / 100);
    }
}