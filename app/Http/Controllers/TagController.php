<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::all();

        return new TagCollection($tags);
    }

    public function store(TagStoreRequest $request)
    {
        $tag = Tag::create($request->validated());

        return new TagResource($tag);
    }

    public function show(Request $request, Tag $tag)
    {
        return new TagResource($tag);
    }

    public function update(TagUpdateRequest $request, Tag $tag)
    {
        $tag->update($request->validated());

        return new TagResource($tag);
    }

    public function destroy(Request $request, Tag $tag)
    {
        $tag->delete();

        return response()->noContent();
    }
}
