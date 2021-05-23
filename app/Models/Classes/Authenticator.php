<?php namespace Models\Classes;

class Authenticator
{
    public string $slug;
    public string $description;
    public int $value;
    public bool $isActivated;

    public function __construct(string $slug, string $description, int $value)
    {
        $this->slug = $slug;
        $this->description = $description;
        $this->value = $value;
        $this->isActivated = false;
    }
}
