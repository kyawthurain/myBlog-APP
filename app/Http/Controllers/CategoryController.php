<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withExists([
            'users as is_added' => function ($query){
                $query->where('user_id',auth()->id());
            }
        ])->latest()->get();
        return response()->json([
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->all());
        return [
            'category' => $category,
            'message' => 'category is created successfully'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());
         return [
            'category' => $category,
            'message' => 'category is updated successfully'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
         return [

            'message' => 'category is deleted successfully'
        ];
    }
}
