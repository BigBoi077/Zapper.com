<?php namespace Models\Classes;

class Queries
{
    public static function getUserInsertQuery(): string
    {
        return "INSERT INTO \"user\" (firstname, lastname, username, email, phone, password) 
                VALUES (?, ?, ?, ?, ?, ?)";
    }

    public static function getUsernameExistQuery(): string
    {
        return "SELECT username 
                FROM \"user\" 
                WHERE username = ?";
    }

    public static function getUserByUsernameQuery(): string
    {
        return "SELECT * 
                FROM \"user\" 
                WHERE username = ?";
    }

    public static function getUserByIdQuery(): string
    {
        return "SELECT * 
                FROM \"user\" 
                WHERE id = ?";
    }

    public static function getTokenInsertQuery(): string
    {
        return "INSERT INTO \"token\" (id_user, value) 
                VALUES (?, ?)";
    }

    public static function getTokenDeleteQuery(): string
    {
        return "DELETE FROM \"token\" 
                WHERE id_user = ?";
    }

    public static function getTokenExistQuery(): string
    {
        return "SELECT *
                FROM \"token\"
                WHERE value = ?";
    }
}
