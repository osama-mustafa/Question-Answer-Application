<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::paginate(10);
        return view('admin.tags.index', compact('tags'));
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(storeTagRequest $request, $id)
    {
        $tag                = Tag::findOrFail($id);
        $tag->title         = $request->title;
        $tag->description   = $request->description;
        $tag->save();
        return back()->with('message', 'Tag has been updated successfully');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('message', 'Tag has been deleted successfully');
    }

    public function restoreTrashed($id)
    {
        $tag = Tag::withTrashed()->findOrFail($id);
        $tag->restore();
        return back()->with('message', 'Tag has been restored successfully');
    }
}
