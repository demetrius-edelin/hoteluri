<?php

namespace App\Http\Classes;

class Hotel
{
    protected $etaje = [];
    protected $nume;

    public function __construct($nume)
    {
        $this->nume = $nume;
    }

    public function adaugaEtaj(Etaj $etaj)
    {
        $this->etaje[$etaj->getNumar()] = $etaj;
    }

    /**
     * @return array
     */
    public function getEtaje()
    {
        return $this->etaje;
    }

    /**
     * @return mixed
     */
    public function getNume()
    {
        return $this->nume;
    }

}
