<?php
namespace Snippet\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Query;

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

    public function countSnippetsByCategoryAndGroup(string $categoryName, string $groupName)
    {
        $phql = 'SELECT COUNT(Snippet\Models\Snippets.id) AS total FROM Snippet\Models\Snippets ' .
                'INNER JOIN Snippet\Models\Acls ' .
                'ON Snippet\Models\Acls.snippet_id = Snippet\Models\Snippets.id ' .
                'INNER JOIN Snippet\Models\Groups ' .
                'ON Snippet\Models\Groups.id = Snippet\Models\Acls.group_id ' .
                'INNER JOIN Snippet\Models\SnippetCategories ' .
                'ON Snippet\Models\SnippetCategories.snippet_id = Snippet\Models\Snippets.id ' .
                'INNER JOIN Snippet\Models\Categories ' .
                'ON Snippet\Models\Categories.id = Snippet\Models\SnippetCategories.category_id ' .
                'WHERE Snippet\Models\Categories.name = :categoryName: AND Snippet\Models\Groups.name = :groupName: ' .
                'LIMIT 1';
        $modelsManager = $this->getModelsManager();
        $row = $modelsManager->executeQuery($phql, [
            'categoryName' => $categoryName,
            'groupName' => $groupName
        ]);
        return (int) $row[0]->total;
    }

    public function findSnippetsByCategoryAndGroup(string $categoryName, string $groupName, int $offset, int $take)
    {
        $phql = 'SELECT Snippet\Models\Snippets.* FROM Snippet\Models\Snippets ' .
                'INNER JOIN Snippet\Models\Acls ' .
                'ON Snippet\Models\Acls.snippet_id = Snippet\Models\Snippets.id ' .
                'INNER JOIN Snippet\Models\Groups ' .
                'ON Snippet\Models\Groups.id = Snippet\Models\Acls.group_id ' .
                'INNER JOIN Snippet\Models\SnippetCategories ' .
                'ON Snippet\Models\SnippetCategories.snippet_id = Snippet\Models\Snippets.id ' .
                'INNER JOIN Snippet\Models\Categories ' .
                'ON Snippet\Models\Categories.id = Snippet\Models\SnippetCategories.category_id ' .
                'WHERE Snippet\Models\Categories.name = :categoryName: AND Snippet\Models\Groups.name = :groupName: ' .
                'LIMIT :take: OFFSET :offset: ';
        $modelsManager = $this->getModelsManager();
        return $modelsManager->executeQuery($phql, [
            'categoryName' => $categoryName,
            'groupName' => $groupName,
            'take' => $take,
            'offset' => $offset
        ], [
             //need to include type to avoid take offset added with quote
            'take' => \Phalcon\Db\Column::BIND_PARAM_INT,
            'offset' => \Phalcon\Db\Column::BIND_PARAM_INT
        ]);
    }
}
