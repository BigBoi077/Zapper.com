<?php namespace Models\Classes;

class MenuItem
{
    public function __construct(String $name, String $href)
    {
        $this->name = $name;
        $this->href = $href;
    }
}
