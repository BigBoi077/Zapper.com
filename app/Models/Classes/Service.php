<?php namespace Models\Classes;

class Service
{
    public int $id;
    public String $name;
    public String $imagePath;

    public function __construct(\stdClass $result = null)
    {
        if (is_null($result)) {
            return;
        }
        $this->id = $result->id_service;
        $this->name = $result->name;
        $this->imagePath = $result->image_path;
    }
}
