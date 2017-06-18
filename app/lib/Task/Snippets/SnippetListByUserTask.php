<?php
namespace Snippet\Task\Snippets;

use Snippet\Models\Snippets;
use Snippet\Models\Groups;
use Snippet\Models\Users;

/**
 * Class that encapsulate snippet list task for specific user
 */
class SnippetListByUserTask extends BaseSnippetTask
{
    /**
     * list all snippets created by a user
     */
    public function listSnippetByUsername($username, $offset, $take)
    {
        $user = Users::findFirstByUsername($username);

        return $user->getSnippets([
            'limit' => $take,
            'offset' => $offset
        ]);
    }

    /**
     * list snippets created by a user that belong to a group
     */
    public function listSnippetInGroupByUsername($groupName, $username, $offset, $take)
    {
        $group = Groups::findFirstByName($groupName);
        $user = Users::findFirstByUsername($username);

        return $group->getSnippets([
            'user_id = :userId:',
            'bind' => [
                 'userId' => $user->id
            ],
            'limit' => $take,
            'offset' => $offset
        ]);
    }

    /**
     * count snippets created by a user that belong to a group
     */
    public function countSnippetInGroupByUsername($groupName, $username)
    {
        $group = Groups::findFirstByName($groupName);
        $user = Users::findFirstByUsername($username);

        return $group->getSnippets([
            'user_id = :userId:',
            'bind' => [
                'userId' => $user->id
            ]
        ])->count();
    }

    public function listPublicSnippetByUsername($username, $offset, $take)
    {
        return $this->listSnippetInGroupByUsername('public', $username,  $offset, $take);
    }

    public function countPublicSnippetByUsername($username, $offset, $take)
    {
        return $this->countSnippetInGroupByUsername('public', $username,  $offset, $take);
    }

}
