<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface
{
    public function categoriesByTenant(string $uuid);
    public function getCategoriesByTenantId(int $idTenant);
    public function getCategoryByUrl(string $url);
}