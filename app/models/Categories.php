<?php
namespace Snippet\Models;

use Phalcon\Mvc\Model;

class Categories extends Model
{
    public $id;
    public $name;

    public function initialize()
    {
        //get list of snippet in a category
        $this->hasManyToMany('id',
                             'Snippet\Models\SnippetCategories', 'category_id', 'snippet_id',
                             'Snippet\Models\Snippets', 'id',
                             ['alias' => 'snippets']);
    }
}
