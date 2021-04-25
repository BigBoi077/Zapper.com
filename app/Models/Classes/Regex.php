<?php namespace Models\Classes;

class Regex
{
    public static string $username = "[A-Za-z][A-Za-z0-9]{5,31}";
    public static string $password = "(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}";
}