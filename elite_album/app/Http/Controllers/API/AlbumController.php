<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Album::all());  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string',
        'year' => 'required|digits:4|integer',
        'sales' => 'required|integer',
        'artist_id' => 'required|exists:artists,id',
        'cover_image' => 'nullable|image|max:2048', // validate image
        ]);

        $coverPath = null;

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('album_covers', 'public');
        }

        $album = Album::create([
            'artist_id' => $request->artist_id,
            'name' => $request->name,
            'year' => $request->year,
            'sales' => $request->sales,
            'cover_image' => $coverPath,
        ]);

        return response()->json([
            'message' => 'Album created successfully.',
            'album' => $album
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $album = Album::find($id);
        if (! $album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        return response()->json($album);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $album = Album::find($id);
        if (! $album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'year' => 'required|digits:4|integer',
            'sales' => 'required|integer',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image && Storage::disk('public')->exists($album->cover_image)) {
                Storage::disk('public')->delete($album->cover_image);
            }

            $album->cover_image = $request->file('cover_image')->store('album_covers', 'public');
        }

        $album->update([
            'name' => $request->name,
            'year' => $request->year,
            'sales' => $request->sales,
            'cover_image' => $album->cover_image
        ]);

        return response()->json(['message' => 'Album updated successfully', 'album' => $album]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $album = Album::find($id);
        if (! $album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        // Delete cover image if exists
        if ($album->cover_image && Storage::exists($album->cover_image)) {
            Storage::delete($album->cover_image);
        }

        $album->delete();
        return response()->json(['message' => 'Album deleted successfully']);
    }
}
