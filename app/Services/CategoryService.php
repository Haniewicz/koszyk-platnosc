<?php
//This is Service file. You should write your logic in here
namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function __construct(private Category $category = new Category())
    {
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function assignAttributes(string $name): self
    {
        $this->category->name = $name;
        $this->category->save();
        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }
}

?>
