<?php

namespace App\Http\Classes;

class Hotel
{
    protected $etaje = [];
    protected $nume;
    protected $id;
    protected $total_locuri = 0;
    protected $ocupare_locuri = 0;

    public function __construct($id, $nume)
    {
        $this->id = $id;
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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTotalLocuri()
    {
        return $this->total_locuri;
    }

    /**
     * @param int $total_locuri
     */
    public function setTotalLocuri($total_locuri)
    {
        $this->total_locuri = $total_locuri;
    }

    /**
     * @return int
     */
    public function getOcupareLocuri()
    {
        return $this->ocupare_locuri;
    }

    /**
     * @param int $ocupare_locuri
     */
    public function setOcupareLocuri($ocupare_locuri)
    {
        $this->ocupare_locuri = $ocupare_locuri;
    }

    public function situatieOcupare()
    {
        return $this->ocupare_locuri . '/' . $this->total_locuri;
    }
}
