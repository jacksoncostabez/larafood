<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdatePermission extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->segment(3);
        //{$id},id", Essa parte resolve o problema na hora de editar a descrição e deixar o mesmo nome.
        return [
            'name' => "required|min:3|max:255|unique:profiles,name,{$id},id",
            'description' => "nullable|min:3|max:255",
        ];
    }
}
