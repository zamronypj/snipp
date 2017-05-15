<?php
namespace Snippet\Models;

use Phalcon\Mvc\Model;

class Snippets extends Model
{
    public $id;
    public $title;
    public $content;
    public $user_id;
    public $download_count;
    public $created_at;
    public $updated_at;

    public function initialize()
    {
        $this->belongsTo('user_id', 'Snippet\Models\Users', 'id', ['alias' => 'creator']);
        $this->hasManyToMany('id',
                             'Snippet\Models\SnippetCategories', 'snippet_id', 'category_id',
                             'Snippet\Models\Categories', 'id',
                             ['alias' => 'categories']);
    }
}