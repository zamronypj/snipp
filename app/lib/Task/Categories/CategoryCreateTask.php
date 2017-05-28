<?php
namespace Snippet\Task\Categories;

use Snippet\Models\Categories;
use \StdClass;

/**
 * Class that encapsulate category create task
 */
class CategoryCreateTask extends BaseCategoryTask
{
    private function createCategory(string $categoryName)
    {
        $category = new Categories();
        $category->name = $categoryName;
        $category->save();
        return $category;
    }

    public function createCategoriesIfNotExist(array $arrayOfCategories)
    {
        $categoryIds = [];
        foreach ($arrayOfCategories as $categoryName) {
            $category = Categories::findFirstByName($categoryName);
            if (is_null($category)) {
                $category = $this->createCategory($categoryName);
            }
            $categoryIds[] = $category->id;
        }
    }
}
