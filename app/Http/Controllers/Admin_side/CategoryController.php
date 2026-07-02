<?php

namespace App\Http\Controllers\Admin_side;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Word;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin_side.categories');
    }
    // GET /admin/categories (AJAX)
    public function showCategory(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $limit = (int) $request->input('limit', 10);

        $query = Category::query();

        if ($keyword !== '') {
            $query->where('category_name', 'LIKE', "%{$keyword}%");
        }

        $categories = $query->orderByDesc('created_at')->paginate($limit);

        // Ensure consistent structure even if DB is empty
        $data = $categories->items();
        $totalPages = $categories->lastPage() > 0 ? $categories->lastPage() : 1;
        $currentPage = $categories->currentPage() > 0 ? $categories->currentPage() : 1;

        return response()->json([
            'success' => true,
            'data' => $data,
            'total_pages' => $totalPages,
            'current_page' => $currentPage,
        ]);
    }


    // POST /admin/categories/add
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:100|unique:categories,category_name',
            'reviewer_text' => 'required|string',
            'english' => 'required|array',
            'tagalog' => 'required|array',
            'sentence' => 'required|array',
        ]);

        $category = Category::create([
            'category_name' => $request->category_name,
            'module' => $request->reviewer_text,
        ]);

        foreach ($request->english as $index => $englishWord) {
            Word::create([
                'english_word' => $englishWord,
                'tagalog_word' => $request->tagalog[$index] ?? '',
                'example_sentence' => $request->sentence[$index] ?? '',
                'category_id' => $category->id,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Category added successfully']);
    }

    // POST /admin/categories/get
    public function show(Request $request)
    {
        $category = Category::with('words')->find($request->id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found']);
        }

        return response()->json([
            'success' => true,
            'category' => $category,
            'words' => $category->words,
        ]);
    }

    // POST /admin/categories/update
    public function update(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'category_name' => 'required|string|max:100',
            'reviewer_text' => 'required|string',
            'english' => 'required|array',
            'tagalog' => 'required|array',
            'sentence' => 'required|array',
        ]);

        $category = Category::find($request->category_id);

        $category->update([
            'category_name' => $request->category_name,
            'module' => $request->reviewer_text,
        ]);

        // Replace all words for this category
        $category->words()->delete();

        foreach ($request->english as $index => $englishWord) {
            Word::create([
                'english_word' => $englishWord,
                'tagalog_word' => $request->tagalog[$index] ?? '',
                'example_sentence' => $request->sentence[$index] ?? '',
                'category_id' => $category->id,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Category updated successfully']);
    }

    // POST /admin/categories/delete
    public function destroy(Request $request)
    {
        $request->validate(['id' => 'required|integer|exists:categories,id']);

        $category = Category::find($request->id);
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
    }
}
