<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('category.list', [
            'title' => 'Category List',
            'categories' => Category::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('category.create', [
            'title' => 'New Category',
            'categories' => Category::paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $this->validateCategory($request);
        Category::create($validatedData);
        return redirect()->route('categories.index')->with('message', 'Category added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return view('category.show', [
            'title' => 'Category Detail',
            'category' => $category,
            'news' => $category->news()->paginate(10)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        return view('category.edit', [
            'title' => 'Edit Category',
            'category' => $category,
            'categories' => Category::paginate(10)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $validatedData = $this->validateCategory($request);
        $category->update($validatedData);
        return redirect()->route('categories.index')->with('message', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $category->delete();
        return redirect()->route('categories.index')->with('message', 'Category deleted successfully!');
    }

    /**
     * Validate category data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $categoryId
     * @return array
     */
    protected function validateCategory(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
        ]);
    }
}