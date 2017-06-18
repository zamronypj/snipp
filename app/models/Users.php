<?php
namespace Snippet\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;

class Users extends Model
{
    public $id;
    public $username;
    public $userpswd;
    public $email;

    public function initialize()
    {
        $this->hasOne('id', 'Snippet\Models\UserDetails', 'user_id', ['alias' => 'detail']);
        $this->hasMany('id', 'Snippet\Models\Snippets', 'user_id', ['alias' => 'snippets']);
        $this->hasManyToMany('id',
                    'Snippet\Models\UserGroups', 'user_id', 'group_id',
                    'Snippet\Models\Groups', 'id',
                    ['alias' => 'groups']);
    }

    public function getAvailableSnippets($offset, $take)
    {
        $phql = 'SELECT Snippet\Models\Snippets.* FROM Snippet\Models\Snippets ' .
                'INNER JOIN Snippet\Models\Acls ' .
                'ON  Snippet\Models\Snippets.id = Snippet\Models\Acls.snippet_id ' .
                'INNER JOIN Snippet\Models\Groups ' .
                'ON  Snippet\Models\Groups.id = Snippet\Models\Acls.group_id ' .
                'INNER JOIN Snippet\Models\UserGroups ' .
                'ON  Snippet\Models\Groups.id = Snippet\Models\UserGroups.group_id ' .
                'INNER JOIN Snippet\Models\Users ' .
                'ON  Snippet\Models\Users.id  = Snippet\Models\UserGroups.user_id ' .
                'WHERE Snippet\Models\Users.id = :userId: ' .
                'LIMIT :take: OFFSET :offset:';
        $modelsManager = $this->getModelsManager();
        return $modelsManager->executeQuery($phql, [
            'userId' => $this->id,
            'take' => $take,
            'offset' => $offset
        ], [
             //need to include type to avoid take offset added with quote
            'take' => \Phalcon\Db\Column::BIND_PARAM_INT,
            'offset' => \Phalcon\Db\Column::BIND_PARAM_INT
        ]);
    }

    public function countAvailableSnippets()
    {
        $phql = 'SELECT COUNT(Snippet\Models\Snippets.id) AS total FROM Snippet\Models\Snippets ' .
                'INNER JOIN Snippet\Models\Acls ' .
                'ON  Snippet\Models\Snippets.id = Snippet\Models\Acls.snippet_id ' .
                'INNER JOIN Snippet\Models\Groups ' .
                'ON  Snippet\Models\Groups.id = Snippet\Models\Acls.group_id ' .
                'INNER JOIN Snippet\Models\UserGroups ' .
                'ON  Snippet\Models\Groups.id = Snippet\Models\UserGroups.group_id ' .
                'INNER JOIN Snippet\Models\Users ' .
                'ON  Snippet\Models\Users.id  = Snippet\Models\UserGroups.user_id ' .
                'WHERE Snippet\Models\Users.id = :userId: ' .
                'LIMIT 1';
        $modelsManager = $this->getModelsManager();
        $row = $modelsManager->executeQuery($phql, [
            'userId' => $this->id
        ]);
        return (int) $row[0]->total;
    }
}
