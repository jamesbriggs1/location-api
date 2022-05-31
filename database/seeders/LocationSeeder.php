<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Location;

use MatanYadaev\EloquentSpatial\Objects\Point;

class LocationSeeder extends Seeder
{
    private function readCSV($csvFile)
    {
        $handle = fopen($csvFile, 'r');
        while (!feof($handle)) {
            $line[] = fgetcsv($handle, 0, ',');
        }
        fclose($handle);
        return $line;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->readCSV('locations.csv');

        foreach ($data as $row) {
            Location::create([
                'name' => $row[0],
                'position' => new Point($row[1], $row[2]),
            ]);
        }
    }
}
