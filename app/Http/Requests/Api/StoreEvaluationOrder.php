<?php

namespace App\Http\Requests\Api;

use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //essas validações é para saber quem estar fazendo a avaliação da venda, se é o cara que comprou.

        //pega o cliente autenticado.
        if (!$client = auth()->user()) {
            return false;
        }

        //verifica a ordem passada no parâmetro.
        if (!$order = app(OrderRepositoryInterface::class)->getOrderByIdentify($this->identifyOrder)) {
            return false;
        }
        //$this->identifyOrder -> Pega o identificador da venda passado como parâmetro na URL.

        return $client->id == $order->client_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stars' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'min:3', 'max:1000'],
        ];
    }
}