<?php

namespace App\Http\Controllers;

use App\News;
use App\User;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('news.list', [
            'title' => 'News List',
            'news' => News::with(['category', 'user'])->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('news.create', [
            'title' => 'Create News',
            'categories' => \App\Category::all(),
            'users' => \App\User::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $this->validation($request);
        $data['user_id'] = Auth::id(); // Set the authenticated user as the author
        $data['status'] = 'draft'; // Default status to draft
        $data['published_at'] = null; // Default published_at to null
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }
        News::create($data);
        return redirect()->route('news.index')->with('message', 'News added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
        return view('news.show', [
            'title' => 'News Detail',
            'news' => $news,
            'category' => $news->category,
            'user' => $news->user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('news.edit', [
            'title' => 'Edit News',
            'news' => $news,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        //
        $data = $this->validation($request);
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->image) {
                \Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }
        $news->update($data);
        return redirect()->route('news.index')->with('message', 'News updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
        if ($news->image) {
            \Storage::disk('public')->delete($news->image);
        }
        $news->delete();
        return redirect()->route('news.index')->with('message', 'News deleted successfully!');
    }

    public function publish(News $news)
    {
        $news->status = 'published';
        $news->published_at = now();
        $news->save();

        return redirect()->route('news.index')->with('message', 'News published successfully!');
    }

    public function validation(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);
    }
}
