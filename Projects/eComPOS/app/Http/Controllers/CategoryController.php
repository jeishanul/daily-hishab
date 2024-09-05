<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CategoryRepository::query()->whereNull('category_id')->orderByDesc('id')->get();
        return view('category.index', compact('categories'));
    }

    public function subcategory()
    {
        $categories = CategoryRepository::query()->whereNull('category_id')->orderByDesc('id')->get();
        $subcategories = CategoryRepository::query()->whereNotNull('category_id')->orderByDesc('id')->get();

        return view('category.subcategory', compact('categories', 'subcategories'));
    }

    public function store(CategoryRequest $request)
    {
        CategoryRepository::storeByRequest($request);
        return back()->with('success', 'Category inserted successfully');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        CategoryRepository::updateByRequest($request, $category);
        return back()->withSuccess('Category updated successfully');
    }
    public function delete(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully');
    }

    public function downloadSample()
    {
        return response()->download(public_path('import/sample_category.csv'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv'
        ]);
        $file = $request->file('file');
        $csvData = array_map('str_getcsv', file($file));
        try {
            foreach ($csvData as $key => $row) {
                if ($key > 0) {
                    $category = CategoryRepository::query()->where('name', $row[1])->first();
                    Category::create([
                        'name' => $row[0],
                        'category_id' => $category?->id,
                    ]);
                }
            }
            return back()->with('success', 'Categories import successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Please provide valid data in the csv file!');
        }
    }

    public function category_print(Request $request)
    {
        $categories = CategoryRepository::query()->limit($request->length)->orderByDesc('id')->get();
        return view('category.category_print', compact('categories'));
    }
}
