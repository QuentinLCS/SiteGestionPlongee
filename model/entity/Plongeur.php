<?php


class Plongeur
{
    private $per_num;

    private $apt_code;

    /**
     * @return mixed
     */
    public function getPerNum()
    {
        return $this->per_num;
    }

    /**
     * @param mixed $per_num
     */
    public function setPerNum($per_num)
    {
        $this->per_num = $per_num;
    }

    /**
     * @return mixed
     */
    public function getAptCode()
    {
        return $this->apt_code;
    }

    /**
     * @param mixed $apt_code
     */
    public function setAptCode($apt_code)
    {
        $this->apt_code = $apt_code;
    }



}