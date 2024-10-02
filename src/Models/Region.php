<?php

namespace App\Models;

class Region
{
    private string $code;
    private string $nom;

    public function getCode(): string
    {
        return 'N°'.$this->code;
    }

    public function setCode(string $code): Region
    {
        $this->code = $code;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): Region
    {
        $this->nom = $nom;
        return $this;
    }




}