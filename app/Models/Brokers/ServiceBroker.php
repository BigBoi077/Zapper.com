<?php namespace Models\Brokers;

use Models\Classes\Service;
use Models\Classes\User;
use Models\Classes\Queries;

class ServiceBroker extends Broker
{

    public function addService(User $user, Service $service, string $cryptPassword)
    {
        $sql = Queries::getServiceInsertQuery();
        $this->query($sql, [$user->id, $service->id, $user->username, $cryptPassword]);
    }

    public function getAllService(): array
    {
        $sql = Queries::getAllServiceQuery();
        return $this->select($sql);
    }

    public function getUserServices(User $user)
    {
        $sql = Queries::getUserServicesQuery();
    }

    public function serviceExist(string $service): bool
    {
        $sql = Queries::getServiceExistQuery();
        $result = $this->selectSingle($sql, [$service]);
        return !is_null($result);
    }
}
