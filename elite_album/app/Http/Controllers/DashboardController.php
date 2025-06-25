<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Album;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
public function totalSales() //total sales per artist
{
    return Artist::withSum('albums as total_sales', 'sales')->get();
}

public function combinedSales()//combined sales of all albums
{
    return response()->json([
        'combined_sales' => Album::sum('sales')
    ]);
}

// Top 1 artist
public function topArtist()//top artist based on total sales
{
    return Artist::withSum('albums as total_sales', 'sales')
        ->orderByDesc('total_sales')->first();
}


public function albumsByArtist($artist)
{
    $artist = Artist::where('name', 'LIKE', "%{$artist}%")->firstOrFail();
    return $artist->albums;
}
}
