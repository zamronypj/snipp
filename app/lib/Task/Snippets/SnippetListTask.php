<?php
namespace Snippet\Task\Snippets;

use Snippet\Models\Snippets;
use Snippet\Models\Groups;
use Snippet\Models\Users;

/**
 * Class that encapsulate snippet list task
 */
class SnippetListTask extends BaseSnippetTask
{

    public function listSnippetByGroup($groupName, $offset, $take)
    {
        $group = Groups::findFirstByName($groupName);

        return $group->getSnippets([
            'limit' => $take,
            'offset' => $offset
        ]);
    }

    public function countSnippetByGroup($groupName)
    {
        $group = Groups::findFirstByName($groupName);
        return $group->snippets->count();
    }

    private function listPublicSnippet($offset, $take)
    {
        return $this->listSnippetByGroup('public', $offset, $take);
    }

    private function countPublicSnippet()
    {
        return $this->countSnippetByGroup('public');
    }

    private function listAvailableSnippetForCurrentUser($user, $offset, $take)
    {
        return $user->getAvailableSnippets($offset, $take);
    }

    private function countAvailableSnippetForCurrentUser($user)
    {
        return $user->countAvailableSnippets();
    }

    public function listAvailableSnippet($user, $offset, $take)
    {
        if (! isset($user)) {
            return $this->listPublicSnippet($offset, $take);
        } else {
            return $this->listAvailableSnippetForCurrentUser($user, $offset, $take);
        }
    }

    public function countAvailableSnippet($user)
    {
        if (! isset($user)) {
            return $this->countPublicSnippet();
        } else {
            return $this->countAvailableSnippetForCurrentUser($user);
        }
    }
}
