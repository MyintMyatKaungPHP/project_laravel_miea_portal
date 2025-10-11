<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of all posts.
     */
    public function index(): JsonResponse
    {
        $posts = Post::with(['user', 'category'])
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $posts,
        ]);
    }

    /**
     * Display a listing of published posts only.
     */
    public function published(): JsonResponse
    {
        $posts = Post::with(['user', 'category'])
            ->where('published', true)
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $posts,
        ]);
    }

    /**
     * Display posts by category.
     */
    public function byCategory($categoryId): JsonResponse
    {
        $posts = Post::with(['user', 'category'])
            ->where('category_id', $categoryId)
            ->where('published', true)
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $posts,
        ]);
    }

    /**
     * Store a newly created post.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:posts,slug|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'published' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = [
            'title' => $request->input('title'),
            'slug' => $request->input('slug') ?? Str::slug($request->input('title')),
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id'),
            'user_id' => auth()->id(),
            'tags' => $request->input('tags'),
            'published' => $request->input('published', false),
        ];

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $post = Post::create($data);
        $post->load(['user', 'category']);

        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'Post created successfully.',
        ], 201);
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post): JsonResponse
    {
        $post->load(['user', 'category']);

        return response()->json([
            'success' => true,
            'data' => $post,
        ]);
    }

    /**
     * Display the specified post by slug.
     */
    public function showBySlug($slug): JsonResponse
    {
        $post = Post::with(['user', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $post,
        ]);
    }

    /**
     * Update the specified post.
     */
    public function update(Request $request, Post $post): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:posts,slug,' . $post->id . '|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'published' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = [
            'title' => $request->input('title'),
            'slug' => $request->input('slug') ?? Str::slug($request->input('title')),
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id'),
            'tags' => $request->input('tags'),
            'published' => $request->input('published', $post->getAttribute('published')),
        ];

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $post->update($data);
        $post->load(['user', 'category']);

        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'Post updated successfully.',
        ]);
    }

    /**
     * Remove the specified post.
     */
    public function destroy(Post $post): JsonResponse
    {
        // Delete thumbnail if exists
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully.',
        ]);
    }

    /**
     * Publish the specified post.
     */
    public function publish(Post $post): JsonResponse
    {
        $post->update(['published' => true]);
        $post->load(['user', 'category']);

        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'Post published successfully.',
        ]);
    }

    /**
     * Unpublish the specified post.
     */
    public function unpublish(Post $post): JsonResponse
    {
        $post->update(['published' => false]);
        $post->load(['user', 'category']);

        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'Post unpublished successfully.',
        ]);
    }
}
