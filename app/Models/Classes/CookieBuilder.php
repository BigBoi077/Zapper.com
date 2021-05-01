<?php namespace Models\Classes;

use \Zephyrus\Network\Cookie;

class CookieBuilder
{

    public static function build(string $name, string $value)
    {
        $cookie = new Cookie($name, $value);
        $cookie->setLifetime(Cookie::DURATION_YEAR);
        $cookie->send();
    }

    public static function destroy(string $name)
    {
        $cookie = new Cookie($name);
        $cookie->setLifetime(time() - 1);
        $cookie->setPath('/');
        $cookie->setValue('');
        $cookie->destroy();
        $cookie->send();
    }
}
