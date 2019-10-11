<?php


abstract class _Entity
{
    public function __construct(array $data)
    {

        foreach ($data as $key=>$value) {

            $tab = null; $method = null;

            foreach (explode('_', strtolower($key)) as $word)
                $tab[] = ucfirst($word);

            $method = 'set'.implode($tab);

            if(method_exists($this, $method))
                $this->$method($value);
        }
    }
}