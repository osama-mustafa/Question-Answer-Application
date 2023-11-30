<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeTagRequest;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = Tag::with('questions')->paginate(10);
        return view('admin.tags.index', ['tags' => $tags]);
    }

    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', ['tag' => $tag]);
    }

    public function update(storeTagRequest $request, Tag $tag): RedirectResponse
    {
        $tag->update($request->validated());
        return back()->with('message', 'Tag has been updated successfully');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();
        return back()->with('message', 'Tag has been deleted successfully');
    }
}
