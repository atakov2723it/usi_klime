<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_filters_by_search_query(): void
    {
        Product::factory()->create(['name' => 'Daikin Sensira', 'brand' => 'Daikin']);
        Product::factory()->create(['name' => 'Gree Fairy', 'brand' => 'Gree']);

        $response = $this->get('/catalog?q=Daikin');

        $response->assertOk();
        $response->assertSee('Daikin Sensira');
        $response->assertDontSee('Gree Fairy');
    }
}
