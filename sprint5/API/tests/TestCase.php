<?php

namespace Tests;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, WithFaker;

    protected function setUp(): void
    {

        parent::setUp();
        $this->setUpFaker();
        Artisan::call('migrate:refresh');
    }

    public function headers($user = null): array
    {
        $headers = ['Content-Type' => 'application/json',
            'Accept' => 'application/json'];

        if (!is_null($user)) {
            $token = app('auth')->fromUser($user);
            $headers['Authorization'] = "Bearer $token";
        }

        return $headers;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function addProduct(): \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();
        $productImage = ProductImage::factory()->create();

        $product = Product::factory()->create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'product_image_id' => $productImage->id,
            'is_location_offer' => true]);
        return $product;
    }

    public function addRental(): \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();
        $productImage = ProductImage::factory()->create();

        $product = Product::factory()->create([
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'product_image_id' => $productImage->id,
            'is_rental' => true]);
        return $product;
    }
}
