<?php
//This is Service file. You should write your logic in here
namespace App\Services;
use App\Models\Product;

class ProductService
{
    public function __construct(private Product $product = new Product())
    {
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function assignAttributes(string $name, string $description, float $price, int $category_id): self
    {
        $this->product->name = $name;
        $this->product->description = $description;
        $this->product->price = $price;
        $this->product->save();
        $this->product->categories()->attach($category_id);
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function deleteFromCategory(int $category_id): self
    {
        $this->product->categories()->detach($category_id);
        return $this;
    }
}

?>
