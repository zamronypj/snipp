<?php
namespace Snippet\Models;

use Phalcon\Mvc\Model;

class UserGroups extends Model
{
    public $id;
    public $group_id;
    public $user_id;

    public function initialize()
    {
        $this->belongsTo('user_id', 'Snippet\Models\Users', 'id');
        $this->belongsTo('group_id', 'Snippet\Models\Groups', 'id');
    }
}
