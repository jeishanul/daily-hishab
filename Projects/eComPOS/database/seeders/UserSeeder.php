<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdmin();
        $this->createSupplier();
        $this->createCustomer();
    }
    private function createAdmin()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'media_id' => Media::factory()->create([
                'src' => 'public/defualt/profile.jpg',
                'path' => 'user/',
            ])->id
        ]);

        $user->assignRole('admin');
    }
    private function createSupplier()
    {
        $user = User::factory()->create([
            'name' => 'Supplier',
            'email' => 'supplier@example.com',
            'media_id' => Media::factory()->create([
                'src' => 'public/defualt/profile.jpg',
                'path' => 'user/',
            ])->id
        ]);

        $user->personalInfo()->create([
            'company_name' => 'Company Name',
            'phone' => '123456789',
            'phone_verified_at' => now(),
        ]);

        $user->assignRole('supplier');
    }
    private function createCustomer()
    {
        $user = User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'media_id' => Media::factory()->create([
                'src' => 'public/defualt/profile.jpg',
                'path' => 'user/',
            ])->id
        ]);

        $user->personalInfo()->create([
            'address' => '123 Fake Street',
            'city' => 'Faketown',
            'state' => 'Fakestate',
            'country' => 'Fakecountry',
            'zip_code' => '12345',
        ]);
        $user->assignRole('customer');
    }
}
