<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Api\TenantFormRequest;

interface ProductRepositoryInterface
{
    public function getProductsByTenantId(int $idTenant, array $categories);
    public function getProductByUuid(string $uuid);
}