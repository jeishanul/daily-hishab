<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productUnits = [
            'piece', 'meter', 'kilogram', 'inch', 'paz'
        ];

        foreach ($productUnits as $productUnit) {
            Unit::create([
                'code' => '52147',
                'name' => $productUnit
            ]);
        }
    }
}
