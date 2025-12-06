<?php

namespace Tests\Feature;

use App\Models\Provider;
use App\Models\Quote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_quotes(): void
    {
        $provider = Provider::factory()->create();
        Quote::factory()->count(3)->create(['provider_id' => $provider->id]);

        $response = $this->getJson('/api/quotes');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_create_quote(): void
    {
        $provider = Provider::factory()->create();

        $quoteData = [
            'provider_id' => $provider->id,
            'coverage_type' => 'full',
            'monthly_premium' => 150.00,
            'deductible' => 1000.00,
            'coverage_limit' => 100000.00,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'vehicle_year' => 2020,
            'vehicle_make' => 'Honda',
            'vehicle_model' => 'Civic',
        ];

        $response = $this->postJson('/api/quotes', $quoteData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'provider',
                    'coverage_type',
                    'monthly_premium',
                    'annual_premium',
                ]
            ]);

        $this->assertDatabaseHas('quotes', [
            'customer_email' => 'john@example.com',
            'vehicle_make' => 'Honda',
        ]);
    }

    public function test_can_filter_quotes_by_coverage_type(): void
    {
        $provider = Provider::factory()->create();
        Quote::factory()->create(['provider_id' => $provider->id, 'coverage_type' => 'liability']);
        Quote::factory()->create(['provider_id' => $provider->id, 'coverage_type' => 'full']);

        $response = $this->getJson('/api/quotes?coverage_type=liability');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_delete_quote(): void
    {
        $provider = Provider::factory()->create();
        $quote = Quote::factory()->create(['provider_id' => $provider->id]);

        $response = $this->deleteJson("/api/quotes/{$quote->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('quotes', ['id' => $quote->id]);
    }

    public function test_validates_quote_creation(): void
    {
        $response = $this->postJson('/api/quotes', [
            'coverage_type' => 'invalid',
            'monthly_premium' => -100,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['provider_id', 'coverage_type', 'monthly_premium']);
    }
}
