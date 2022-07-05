<?php

namespace App\Http\Classes;

class Etaj
{
    protected $x;
    protected $y;
    protected $numar;
    protected $camere;
    protected $total_locuri = 0;
    protected $ocupare_locuri = 0;

    public function __construct($numar, $x, $y)
    {
        $this->x = $x;
        $this->y = $y;
        $this->numar = $numar;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return mixed
     */
    public function getNumar()
    {
        return $this->numar;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @return mixed
     */
    public function getCamere()
    {
        return $this->camere;
    }

    public function adaugaCamera(Camera $camera)
    {
        $this->camere[$camera->getNumar()] = $camera;
    }

    /**
     * @return mixed
     */
    public function getTotalLocuri()
    {
        return $this->total_locuri;
    }

    /**
     * @param mixed $total_locuri
     */
    public function setTotalLocuri($total_locuri)
    {
        $this->total_locuri = $total_locuri;
    }

    /**
     * @return mixed
     */
    public function getOcupareLocuri()
    {
        return $this->ocupare_locuri;
    }

    /**
     * @param mixed $ocupare_locuri
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
