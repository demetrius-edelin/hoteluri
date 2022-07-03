<?php

namespace App\Http\Classes;

class Etaj
{
    protected $x;
    protected $y;
    protected $numar;
    protected $camere;

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
}
