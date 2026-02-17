<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private function baseQuery()
    {
        return BlogPost::query()
            ->where('published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $section = trim((string) $request->query('section', 'all'));
        $category = trim((string) $request->query('category', 'all'));

        // “The Zone”-style top tabs (you can rename these anytime)
        $sections = [
            'all' => 'All',
            'nutrition' => 'Nutrition',
            'recipes' => 'Recipes',
            'training' => 'Training',
            'meal-prep' => 'Meal Prep',
            'student' => 'Student',
            'wellness' => 'Wellness',
        ];

        $query = $this->baseQuery()
            ->when($section !== 'all' && $section !== '', fn($qq) => $qq->where('section', $section))
            ->when($category !== 'all' && $category !== '', fn($qq) => $qq->where('category', $category))
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('excerpt', 'like', "%{$q}%")
                        ->orWhere('content', 'like', "%{$q}%");
                });
            });

        // Featured (top)
        $featured = (clone $query)->where('is_featured', true)
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->first();

        // Popular row (top 4)
        $popular = (clone $query)
            ->orderByDesc('views')
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(4)
            ->get();

        // Latest feed
        $posts = $query
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate(9)
            ->withQueryString();

        $categories = $this->baseQuery()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('frontend.blog.index', compact(
            'posts', 'categories', 'q', 'category',
            'section', 'sections', 'featured', 'popular'
        ));
    }

    public function show(string $slug)
{
    $post = $this->baseQuery()
        ->where('slug', $slug)
        ->firstOrFail();

    // bump views
    $post->increment('views');

    // Related: same section first, fallback to same category
    $related = $this->baseQuery()
        ->where('id', '!=', $post->id)
        ->where(function ($q) use ($post) {
            $q->where('section', $post->section)
              ->orWhere('category', $post->category);
        })
        ->orderByRaw('COALESCE(published_at, created_at) DESC')
        ->limit(5)
        ->get();

    // Popular: top by views (excluding current)
    $popular = $this->baseQuery()
        ->where('id', '!=', $post->id)
        ->orderByDesc('views')
        ->orderByRaw('COALESCE(published_at, created_at) DESC')
        ->limit(5)
        ->get();

    return view('frontend.blog.show', compact('post', 'related', 'popular'));
}

}
