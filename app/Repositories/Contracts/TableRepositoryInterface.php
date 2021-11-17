<?php

namespace App\Repositories\Contracts;

interface TableRepositoryInterface
{
    public function tablesByTenant(string $uuid);
    public function getTablesByTenantId(int $idTenant);
    public function getTableByIdentify(string $identify);
}