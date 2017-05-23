<?php
namespace Snippet\Models;

use Phalcon\Mvc\Model;

class Acls extends Model
{
    public $id;
    public $snippet_id;
    public $group_id;

    public function initialize()
    {
        $this->belongsTo('snippet_id', 'Snippet\Models\Snippets', 'id');
        $this->belongsTo('group_id', 'Snippet\Models\Groups', 'id');
    }
}
