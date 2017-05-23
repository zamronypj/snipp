<?php
namespace Snippet\Task\Snippets;

use Snippet\Models\Snippets;
use Snippet\Models\Groups;
use Snippet\Models\Acls;
use Phalcon\Filter;
/**
 * Class that encapsulate snippet detail task
 */
class SnippetDetailTask extends BaseSnippetTask
{
    private function isPublicSnippet($foundSnippet)
    {
        $group = Groups::findFirstByName('public');
        $acl = Acls::find([
            'group_id = :groupId: and snippet_id = :snippetId:',
            'bind' => [
                'groupId' => $group->id,
                'snippetId' => $foundSnippet->id
            ],
            'limit' => 1
        ]);

        return (count($acl));
    }

    private function isPrivateSnippet($foundSnippet, $user)
    {
        if (! isset($user)) {
            //all non-registered user cannot view private snippet
            return null;
        }

        $groupIds = [];
        foreach ($foundSnippet->groups as $group) {
            $groupIds[] = $group->id;
        }

        $userGroups = $user->getGroups([
            'conditions' => 'group_id IN ({groupIds:array})',
            'bind' => [ 'groupIds' => $groupIds ]
        ]);

        return (count($userGroups));
    }

    private function canViewDetail($snippetId, $user)
    {
        $foundSnippet = Snippets::findFirstById($snippetId);
        if (! isset($foundSnippet)) {
            //not found
            return null;
        }

        if ($this->isPublicSnippet($foundSnippet)) {
            //this is public snippet so anyone can view
            return $foundSnippet;
        }

        if ($this->isPrivateSnippet($foundSnippet, $user)) {
            //this is private snippet and user is authorized to view
            return $foundSnippet;
        }

        return null;

    }

    public function viewDetail($snippetId, $user)
    {
        $filter = new Filter();
        $sanitizedSnippetId = $filter->sanitize($snippetId, 'alphanum');
        return $this->canViewDetail($sanitizedSnippetId, $user);
    }

}