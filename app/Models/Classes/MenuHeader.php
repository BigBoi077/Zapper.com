<?php namespace Models\Classes;

class MenuHeader
{
    private array $menuItems = [];

    public function build(): array
    {
        $this->add(new MenuItem("Login", "/Connexion/Login"));
        $this->add(new MenuItem("Register", "/Connexion/Register"));
        $this->add(new MenuItem("Websites", "/General/Main"));
        $this->add(new MenuItem("Account", "/Personal/Account"));
        return $this->menuItems;
    }

    private function add(MenuItem $menuItem)
    {
        array_push($this->menuItems, $menuItem);
    }
}
