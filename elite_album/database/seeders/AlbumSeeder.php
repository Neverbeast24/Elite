<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Album;
use App\Models\Artist;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    
    {
        $faker = Faker::create();

        $csv = fopen(storage_path('app/albums.csv'), 'r');

        if (! $csv) {
            throw new \Exception('CSV file not found at storage/app/albums.csv');
        }

        $header = fgetcsv($csv); 

        while (($row = fgetcsv($csv)) !== false) {
            if (count($row) < 4) continue;

            [$artistName, $albumName, $sales, $releaseDate] = $row;

            $artist = Artist::firstOrCreate(
                ['name' => trim($artistName)],
                ['code' => Str::uuid()]
            );

            try {
                $year = Carbon::createFromFormat('ymd', $releaseDate)->year;
            } catch (\Exception $e) {
                $year = $faker->year(); 
            }

            Album::create([
                'artist_id'   => $artist->id,
                'name'        => trim($albumName),
                'sales'       => (int) $sales,
                'year'        => $year,
                'cover_image' => null 
            ]);
        }

        fclose($csv);

    }
}
