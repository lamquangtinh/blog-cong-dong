<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::withCount('posts')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
        ]);

        $category = Category::create([
            'name' => $data['name'],
            'slug' => Category::generateUniqueSlug($data['name']),
        ]);

        Log::info('Thêm danh mục', [
            'category_id' => $category->id,
            'admin_id' => $request->user()->id,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Đã thêm danh mục.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($category->id)],
        ]);

        $category->update([
            'name' => $data['name'],
            'slug' => Category::generateUniqueSlug($data['name'], $category->id),
        ]);

        Log::info('Sửa danh mục', [
            'category_id' => $category->id,
            'admin_id' => $request->user()->id,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Đã cập nhật danh mục.');
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $postCount = $category->posts()->count();
        $categoryId = $category->id;

        // Khóa ngoại nullOnDelete: các bài thuộc danh mục này không bị xóa,
        // chỉ chuyển về "Chưa phân loại"
        $category->delete();

        Log::info('Xóa danh mục', [
            'category_id' => $categoryId,
            'affected_posts' => $postCount,
            'admin_id' => $request->user()->id,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', "Đã xóa danh mục. {$postCount} bài viết được chuyển về \"Chưa phân loại\".");
    }
}