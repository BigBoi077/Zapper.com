<?php namespace Models\Classes;


class Errors
{

    public static function notEmpty(string $field): string
    {
        return "The $field must not be empty";
    }

    public static function incorrectFormat(string $field): string
    {
        return "The $field format is incorrect";
    }
}