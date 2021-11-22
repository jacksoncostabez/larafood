<?php

namespace App\Services;

use App\Repositories\Contracts\ClientRepositoryInterface;

class ClientService
{
    protected $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepositoryInterface)
    {
        $this->clientRepository = $clientRepositoryInterface;
    }

    public function createNewClient(array $data)
    {
        return $this->clientRepository->createNewClient($data);
    }
}