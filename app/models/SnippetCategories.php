<?php
namespace Snippet\Models;

use Phalcon\Mvc\Model;

class SnippetCategories extends Model
{
    public $id;
    public $snippet_id;
    public $category_id;

    public function initialize()
    {
        $this->belongsTo('snippet_id', 'Snippets', 'id');
        $this->belongsTo('category_id', 'Categories', 'id');
    }
}
