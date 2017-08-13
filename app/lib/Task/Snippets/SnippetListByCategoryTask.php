<?php
namespace Snippet\Task\Snippets;

use Snippet\Models\Categories;
use Snippet\Models\Snippets;

/**
 * Class that encapsulate snippet list by category task
 */
class SnippetListByCategoryTask extends BaseSnippetTask
{
    /**
     * list all snippets created by a user
     */
    public function listSnippetByCategory($categoryName, $offset, $take)
    {
        $category = Categories::findFirstByName($categoryName);
        return $category->getSnippets([
            'limit' => $take,
            'offset' => $offset
        ]);
    }

    /**
     * list snippets in a category that belong to a group
     */
    public function listSnippetInGroupByCategory($groupName, $categoryName, $offset, $take)
    {
        $snippet = new Snippets();
        return $snippet->findSnippetsByCategoryAndGroup($categoryName, $groupName, $offset, $take);
    }

    public function listPublicSnippetInCategory($categoryName, $offset, $take)
    {
        return $this->listSnippetInGroupByCategory('public', $categoryName,  $offset, $take);
    }

    /**
     * count snippets in a category that belong to a group
     */
    public function countSnippetInGroupByCategory($groupName, $categoryName)
    {
        $snippet = new Snippets();
        return $snippet->countSnippetsByCategoryAndGroup($categoryName, $groupName);
    }

    public function countPublicSnippetInCategory($categoryName)
    {
        return $this->countSnippetInGroupByCategory('public', $categoryName);
    }
}
