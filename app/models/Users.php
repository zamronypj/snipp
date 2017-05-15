<?php
namespace Snippet\Models;

use Phalcon\Mvc\Model;

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
}