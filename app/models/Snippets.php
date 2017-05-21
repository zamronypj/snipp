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

        //list of categories where a snippet belong
        $this->hasManyToMany('id',
                             'Snippet\Models\SnippetCategories', 'snippet_id', 'category_id',
                             'Snippet\Models\Categories', 'id',
                             ['alias' => 'categories']);
        //list of groups where a snippet is accessible
        $this->hasManyToMany('id',
                             'Snippet\Models\Acls', 'snippet_id', 'group_id',
                             'Snippet\Models\Groups', 'id',
                             ['alias' => 'groups']);

        $this->addBehavior(new Timestampable([
            'beforeCreate' => [
                'field' => 'created_at',
                'format' => "Y-m-d H:i:s",
            ]
        ]));

        $this->addBehavior(new Timestampable([
            'beforeUpdate' => [
                'field' => 'updated_at',
                'format' => "Y-m-d H:i:s",
            ]
        ]));
    }
}
