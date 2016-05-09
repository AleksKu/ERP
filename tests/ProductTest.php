<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use \Torg\Catalog\Product;
use \Torg\Catalog\ProductCategory;

class ProductTest extends TestCase
{

    use DatabaseTransactions;

    /**
     *
     *
     * @return void
     */
    public function testAddProductToCategory()
    {
        $category = factory(ProductCategory::class)->create()->first();
        $product1 = factory(Product::class)->create()->first();
        $product2 = factory(Product::class)->create()->first();

        $product1->addToCategory($category);
        //$product1->save();
        $this->assertEquals($category->product_count, 1);

        $product2->addToCategory($category);
       // $product2->save();

        $this->assertEquals($category->product_count, 2);


        $this->assertEquals($product2->category->id, $category->id);

    }

    public function testRemoveProductToCategory()
    {
        $category = factory(ProductCategory::class)->create()->first();
        $product1 = factory(Product::class)->create()->first();
        $product2 = factory(Product::class)->create()->first();

        $product1->addToCategory($category);
        //$product1->save();
        $this->assertEquals($category->product_count, 1);

        $product2->addToCategory($category);
        // $product2->save();

        $this->assertEquals($category->product_count, 2);


        $this->assertEquals($product2->category->id, $category->id);

    }
}
