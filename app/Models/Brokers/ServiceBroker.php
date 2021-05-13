<?php namespace Models\Brokers;

use Models\Classes\Service;
use Models\Classes\ServiceUser;
use Models\Classes\ServiceUserModel;
use Models\Classes\User;
use Models\Classes\Queries;

class ServiceBroker extends Broker
{

    public function getAllService(): array
    {
        $sql = Queries::getAllServiceQuery();
        return $this->select($sql);
    }

    public function getUserServices(User $user): array
    {
        $sql = Queries::getUserServicesQuery();
        return $this->select($sql, [$user->id]);
    }

    public function serviceExist(string $service): bool
    {
        $sql = Queries::getServiceByNameQuery();
        $result = $this->selectSingle($sql, [$service]);
        return !is_null($result);
    }

    public function getServiceByName(string $name): Service
    {
        $sql = Queries::getServiceByNameQuery();
        $result = $this->selectSingle($sql, [$name]);
        return new Service($result);
    }

    public function insert(ServiceUser $serviceUser)
    {
        $sql = Queries::getServiceUserInsertQuery();
        $this->query($sql, [
            $serviceUser->userId,
            $serviceUser->serviceId,
            $serviceUser->username,
            $serviceUser->password
        ]);
    }
}
