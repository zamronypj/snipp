<?php
namespace Snippet\Task\Categories;

use Phalcon\Filter;
use Snippet\Models\Categories;
use StdClass;

/**
 * Class that encapsulate category create task
 */
class CategoryCreateTask extends BaseCategoryTask
{
    private function createCategory($categoryName)
    {
        $category = new Categories();
        $category->name = $categoryName;
        $category->save();
        return $category;
    }
    private function sanitizeCategories($unsanitizedCategories)
    {
        $filter = new Filter();
        $filter->add('alphanumdash', function($str){
            return preg_replace('/[^a-zA-Z0-9\-]+/', '', $str);
        });
        $sanitizedCategories = [];
        foreach ($unsanitizedCategories as $categoryName) {
            $sanitizedCategories[] = $filter->sanitize($categoryName, 'alphanumdash');
        }
        return $sanitizedCategories;
    }

    public function createCategoriesIfNotExist(array $unsanitizedArrayOfCategories)
    {
        $arrayOfCategories = $this->sanitizeCategories($unsanitizedArrayOfCategories);
        $categoryIds = [];
        foreach ($arrayOfCategories as $categoryName) {
            $category = Categories::findFirstByName($categoryName);
            if ($category === false) {
                $category = $this->createCategory($categoryName);
            }
            $categoryIds[] = $category->id;
        }
        return $categoryIds;
    }
}
