<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artist;
use Illuminate\Support\Facades\Log;


class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Artist::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:artists,code',
            'name' => 'required|string',
        ]);

        $artist = Artist::create([
            'code' => $request->code,
            'name' => $request->name
        ]);

        return response()->json(['message' => 'Artist created successfully', 'artist' => $artist], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $artist = Artist::find($id);
        if (! $artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }
        return response()->json($artist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $artist = Artist::find($id);
        if (! $artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $request->validate([
            'code' => 'required|string|unique:artists,code,' . $id,
            'name' => 'required|string',
        ]);

        $artist->update([
            'code' => $request->code,
            'name' => $request->name
        ]);

        return response()->json(['message' => 'Artist updated successfully', 'artist' => $artist]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $artist = Artist::find($id);
        if (! $artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $artist->delete();
        return response()->json(['message' => 'Artist deleted successfully']);
    }
}
