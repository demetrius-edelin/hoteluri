<?php

namespace App\Http\Classes;

class Camera
{
    protected $numar;
    protected $locuri;
    protected $x_start;
    protected $x_end;
    protected $y_start;
    protected $y_end;

    public function __construct($numar, $locuri, $x_start, $x_end, $y_start, $y_end)
    {
        $this->numar = $numar;
        $this->locuri = $locuri;
        $this->x_start = $x_start;
        $this->x_end = $x_end;
        $this->y_start = $y_start;
        $this->y_end = $y_end;
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
    public function getLocuri()
    {
        return $this->locuri;
    }

    /**
     * @return mixed
     */
    public function getXStart()
    {
        return $this->x_start;
    }

    /**
     * @return mixed
     */
    public function getXEnd()
    {
        return $this->x_end;
    }

    /**
     * @return mixed
     */
    public function getYStart()
    {
        return $this->y_start;
    }

    /**
     * @return mixed
     */
    public function getYEnd()
    {
        return $this->y_end;
    }


}
