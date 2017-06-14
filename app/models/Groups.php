<?php
namespace Snippet\Models;

use Phalcon\Mvc\Model;

class Groups extends Model
{
    public $id;
    public $name;
    public $display_name;
    public $owner;

    public function initialize()
    {
        //user that create this group
        $this->belongsTo('owner', 'Snippet\Models\Users', 'id', ['alias' => 'creator']);

        //get list of snippet in a group
        $this->hasManyToMany('id',
                             'Snippet\Models\Acls', 'group_id', 'snippet_id',
                             'Snippet\Models\Snippets', 'id',
                             ['alias' => 'snippets']);

        //get list of user in a group
        $this->hasManyToMany('id',
                    'Snippet\Models\UserGroups', 'group_id', 'user_id',
                    'Snippet\Models\Users', 'id',
                    ['alias' => 'users']);
    }

}
