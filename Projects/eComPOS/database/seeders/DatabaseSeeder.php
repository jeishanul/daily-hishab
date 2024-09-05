<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(WalletSeeder::class);
        // $this->call(UnitSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(LanguageSeeder::class);


        if (app()->environment('local')) {
            $this->call([
                UnitSeeder::class,
                CustomerGroupSeeder::class,
                BrandSeeder::class,
                TaxSeeder::class,
                WarehouseSeeder::class,
                CouponSeeder::class,
                CategorySeeder::class,
            ]);
        }

        $this->installStorage();
    }

    private function installStorage()
    {
        $this->command->warn('Installing storage links...');
        Artisan::call('storage:link');
        $this->command->info('Storage links installed successfully.');
    }
}
