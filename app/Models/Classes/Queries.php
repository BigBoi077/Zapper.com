<?php namespace Models\Classes;

class Queries
{
    public static function getUserInsertQuery(): string
    {
        return "INSERT INTO \"user\" (firstname, lastname, username, email, phone, password) VALUES (?, ?, ?, ?, ?, ?)";
    }

    public static function getLastInsertQuery(): string
    {
        return "SELECT currval(pg_get_serial_sequence('user','id'))";
    }
}
