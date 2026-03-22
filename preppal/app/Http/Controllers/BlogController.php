<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Build the base query for published blog posts.
     */
    private function baseQuery()
    {
        return BlogPost::query()
            ->where('published', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Display the blog index page.
     */
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $section = trim((string) $request->query('section', 'all'));
        $category = trim((string) $request->query('category', 'all'));

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
            ->when($section !== 'all' && $section !== '', fn ($blogQuery) => $blogQuery->where('section', $section))
            ->when($category !== 'all' && $category !== '', fn ($blogQuery) => $blogQuery->where('category', $category))
            ->when($q !== '', function ($blogQuery) use ($q) {
                $blogQuery->where(function ($subQuery) use ($q) {
                    $subQuery->where('title', 'like', "%{$q}%")
                        ->orWhere('excerpt', 'like', "%{$q}%")
                        ->orWhere('content', 'like', "%{$q}%");
                });
            });

        $featured = (clone $query)
            ->where('is_featured', true)
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->first();

        $popular = (clone $query)
            ->orderByDesc('views')
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(4)
            ->get();

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
            'posts',
            'categories',
            'q',
            'category',
            'section',
            'sections',
            'featured',
            'popular'
        ));
    }

    /**
     * Display a single blog post.
     */
    public function show(string $slug): View
    {
        $post = $this->baseQuery()
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('views');

        $related = $this->baseQuery()
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                $query->where('section', $post->section)
                    ->orWhere('category', $post->category);
            })
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(5)
            ->get();

        $popular = $this->baseQuery()
            ->where('id', '!=', $post->id)
            ->orderByDesc('views')
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(5)
            ->get();

        return view('frontend.blog.show', compact('post', 'related', 'popular'));
    }
}