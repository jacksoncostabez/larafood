<?php

namespace App\Services;

use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Illuminate\Http\Request;

class OrderService
{
    protected $orderRepository, $tenantRepository, $tableRepository, $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        TenantRepositoryInterface $tenantRepository,
        TableRepositoryInterface $tableRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->tenantRepository = $tenantRepository;
        $this->tableRepository = $tableRepository;
        $this->productRepository = $productRepository;
    }

    public function ordersByClient()
    {
        $idClient = $this->getClientIdByOrder(); // pega o id do client autenticado.

        return $this->orderRepository->getOrdersByClientId($idClient);
    }

    public function getOrderByIdentify(string $identify)
    {
        return $this->orderRepository->getOrderByIdentify($identify);
    }

    public function createNewOrder(array $order)
    {
        $productsOrder = $this->getProductsByOrder($order['products'] ?? []); //pega os produtos da venda
        
        $identify = $this->getIdentifyOrder();
        $total = $this->getTotalOrder($productsOrder);
        $status = 'open';
        $tenantId = $this->getTenantIdByOrder($order['token_company']);
        $comment = isset($order['comment']) ? $order['comment'] : '';
        $clientId = $this->getClientIdByOrder();
        $tableId = $this->getTableIdByOrder($order['table'] ?? '');

        $order = $this->orderRepository->createNewOrder(
            $identify,
            $total,
            $status,
            $tenantId,
            $comment,
            $clientId,
            $tableId
        );

        $this->orderRepository->registerProductsOrder($order->id, $productsOrder);

        return $order;
    }

    private function getIdentifyOrder(int $qtyCaraceters = 8)
    {
        $smallLetters = str_shuffle('abcdefghijklmnopqrstuvwxyz');

        $numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
        $numbers .= 1234567890;

        // $specialCharacters = str_shuffle('!@#$%*-');

        // $characters = $smallLetters.$numbers.$specialCharacters;
        $characters = $smallLetters.$numbers;

        //cria o identificador da venda com 8 caracteres
        $identify = substr(str_shuffle($characters), 0, $qtyCaraceters);

        //Se tiver alguma venda com o identificador gerado
        if ($this->orderRepository->getOrderByIdentify($identify)) {
            $this->getIdentifyOrder($qtyCaraceters + 1); //aumenta 1 caractere no identificador para não ter valores duplicados e cria a venda novamente (recursiva).
        }

        return $identify;
    }

    private function getProductsByOrder(array $productsOrder): array
    {
        $products = [];
        foreach ($productsOrder as $productOrder) {
            $product = $this->productRepository->getProductByUuid($productOrder['identify']); //pega o produto passado na venda pelo uuid

            array_push($products, [
                'id' => $product->id,
                'qty' => $productOrder['qty'],
                'price' => $product->price,
            ]);
        }

        return $products;
    }

    private function getTotalOrder(array $products): float
    {
        $total = 0;

        foreach ($products as $product) {
            $total += ($product['price'] * $product['qty']);
        }

        return (float) $total;
    }

    private function getTenantIdByOrder(string $uuid)
    {
        $tenant = $this->tenantRepository->getTenantByUuid($uuid);

        return $tenant->id;
    }

    private function getTableIdByOrder(string $uuid = '')
    {
        if ($uuid) {
            $table = $this->tableRepository->getTableByUuid($uuid);

            return $table->id;
        }

        return '';
    }

    private function getClientIdByOrder()
    {
        return auth()->check() ? auth()->user()->id : '';
    }

    public function getOrdersByTenantId(int $idTenant, string $status, string $date)
    {
        return $this->orderRepository->getOrdersByTenantId($idTenant, $status, $date);
    }

    public function updateStatusOrder(string $identify, string $status)
    {
        return $this->orderRepository->updateStatusOrder($identify, $status);
    }

}
