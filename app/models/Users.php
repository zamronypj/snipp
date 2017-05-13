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
        $this->hasOne('id', 'Snippet\\Models\\UserDetails', 'user_id');
        $this->hasMany('id', 'Snippets', 'user_id');
        $this->hasManyToMany('id', 'UserGroups', 'user_id', 'group_id', 'Groups', 'id');
    }
}