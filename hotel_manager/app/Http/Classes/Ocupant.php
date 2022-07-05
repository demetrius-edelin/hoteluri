<?php

namespace App\Http\Classes;

class Ocupant
{
    protected $nume;
    protected $prenume;
    protected $an_curs;
    protected $oras;
    protected $tara;
    protected $premiu;
    protected $telefon;

    /**
     * @param $nume
     * @param $prenume
     * @param $an_curs
     * @param $oras
     * @param $tara
     * @param $premiu
     */
    public function __construct($nume, $prenume, $an_curs = '', $oras = '', $tara = '', $telefon = '', $premiu = 0)
    {
        $this->nume = $nume;
        $this->prenume = $prenume;
        $this->an_curs = $an_curs;
        $this->oras = $oras;
        $this->tara = $tara;
        $this->telefon = $telefon;
        $this->premiu = $premiu;
    }

    /**
     * @return int|mixed
     */
    public function getTelefon()
    {
        return $this->telefon;
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
    public function getPrenume()
    {
        return $this->prenume;
    }

    /**
     * @return mixed|string
     */
    public function getAnCurs()
    {
        return $this->an_curs;
    }

    /**
     * @return mixed|string
     */
    public function getOras()
    {
        return $this->oras;
    }

    /**
     * @return mixed|string
     */
    public function getTara()
    {
        return $this->tara;
    }

    /**
     * @return int|mixed
     */
    public function getPremiu()
    {
        return $this->premiu;
    }
}
