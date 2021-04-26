<?php namespace Models\Classes;

class Queries
{
    public static function getUserInsertQuery(): string
    {
        return "INSERT INTO \"user\" (firstname, lastname, username, email, phone, password) 
                VALUES (?, ?, ?, ?, ?, ?)";
    }

    public static function getUsernameExistQuery(string $username): string
    {
        return "SELECT username 
                FROM \"user\" 
                WHERE username = ?";
    }

    public static function getUserByUsername(string $username): string
    {
        return "SELECT * 
                FROM \"user\" 
                WHERE username = ?";
    }

    public static function getUserById(string $id): string
    {
        return "SELECT * 
                FROM \"user\" 
                WHERE id = ?";
    }
}
