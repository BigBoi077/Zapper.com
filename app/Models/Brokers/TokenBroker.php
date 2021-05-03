<?php namespace Models\Brokers;

use Models\Classes\Queries;
use Zephyrus\Security\Cryptography;

class TokenBroker extends Broker
{
    public function insert(int $userId): string
    {
        $sql = Queries::getTokenInsertQuery();
        $value = Cryptography::randomString(64);
        $device = $_SERVER['HTTP_USER_AGENT'];
        $time = date(FORMAT_DATE_TIME);
        $this->query($sql, [$userId, $value, $device, $time]);
        return $value;
    }

    public function deleteUserToken(int $userId)
    {
        $sql = Queries::getTokenDeleteQuery();
        $this->query($sql, [$userId]);
    }

    public function tokenExist(string $value): bool
    {
        $sql = Queries::getTokenExistQuery();
        $result = $this->query($sql, [$value]);
        if ($result->count() == 0) {
            return false;
        }
        return true;
    }

    public function getUserIdByToken(string $tokenValue): int
    {
        $sql = Queries::getUserIdByToken();
        $result = $this->selectSingle($sql, [$tokenValue]);
        return $result->id_user;
    }

    public function getTokensById(int $userId): array
    {
        $sql = Queries::getTokensByIdQuery();
        return $this->select($sql, [$userId]);
    }
}
