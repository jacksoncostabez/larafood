<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TenantFormRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function categoriesByTenant(TenantFormRequest $request)
    {
        /* token_company refere-se ao uuid
        if (!$request->token_company) {
            return response()->json(['message' => 'Token Not Found'], 404);
        }
        */

        $categories = $this->categoryService->getCategoriesByUuid($request->token_company);

        return CategoryResource::collection($categories);
    }

    public function show(TenantFormRequest $request, $identify)
    {
        //dd($this->token_company);
        if (!$category = $this->categoryService->getCategoryByUuid($identify)) {
            return response()->json(['message' => 'Category Not Found'], 404);
        }

        return new CategoryResource($category);
    }
}
