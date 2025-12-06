<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Quote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create insurance providers
        $providers = [
            [
                'name' => 'State Farm',
                'rating' => 4.5,
                'phone' => '800-782-8332',
                'website' => 'https://www.statefarm.com',
            ],
            [
                'name' => 'Geico',
                'rating' => 4.3,
                'phone' => '800-861-8380',
                'website' => 'https://www.geico.com',
            ],
            [
                'name' => 'Progressive',
                'rating' => 4.2,
                'phone' => '800-776-4737',
                'website' => 'https://www.progressive.com',
            ],
            [
                'name' => 'Allstate',
                'rating' => 4.1,
                'phone' => '877-810-2920',
                'website' => 'https://www.allstate.com',
            ],
            [
                'name' => 'Liberty Mutual',
                'rating' => 4.0,
                'phone' => '800-290-7933',
                'website' => 'https://www.libertymutual.com',
            ],
        ];

        foreach ($providers as $providerData) {
            Provider::create($providerData);
        }

        // Create sample quotes
        $coverageTypes = ['liability', 'collision', 'comprehensive', 'full'];
        $vehicles = [
            ['year' => 2020, 'make' => 'Honda', 'model' => 'Civic'],
            ['year' => 2019, 'make' => 'Toyota', 'model' => 'Camry'],
            ['year' => 2021, 'make' => 'Ford', 'model' => 'F-150'],
            ['year' => 2022, 'make' => 'Tesla', 'model' => 'Model 3'],
            ['year' => 2018, 'make' => 'Chevrolet', 'model' => 'Malibu'],
        ];

        $customers = [
            ['name' => 'John Smith', 'email' => 'john.smith@example.com'],
            ['name' => 'Jane Doe', 'email' => 'jane.doe@example.com'],
            ['name' => 'Mike Johnson', 'email' => 'mike.j@example.com'],
            ['name' => 'Sarah Williams', 'email' => 'sarah.w@example.com'],
            ['name' => 'David Brown', 'email' => 'david.b@example.com'],
        ];

        foreach (Provider::all() as $provider) {
            foreach ($coverageTypes as $coverage) {
                foreach (range(0, 2) as $i) {
                    $vehicle = $vehicles[array_rand($vehicles)];
                    $customer = $customers[array_rand($customers)];
                    
                    $basePremium = match($coverage) {
                        'liability' => rand(50, 100),
                        'collision' => rand(80, 150),
                        'comprehensive' => rand(100, 180),
                        'full' => rand(150, 300),
                    };

                    Quote::create([
                        'provider_id' => $provider->id,
                        'coverage_type' => $coverage,
                        'monthly_premium' => $basePremium + rand(-20, 50),
                        'deductible' => [500, 1000, 2000][array_rand([500, 1000, 2000])],
                        'coverage_limit' => [50000, 100000, 250000, 500000][array_rand([50000, 100000, 250000, 500000])],
                        'customer_name' => $customer['name'],
                        'customer_email' => $customer['email'],
                        'vehicle_year' => $vehicle['year'],
                        'vehicle_make' => $vehicle['make'],
                        'vehicle_model' => $vehicle['model'],
                    ]);
                }
            }
        }
    }
}
