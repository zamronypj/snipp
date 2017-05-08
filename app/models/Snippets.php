<?php
namespace Snippet\Models;

use Phalcon\Mvc\Model;

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
        $this->belongsTo('user_id', 'Users', 'id');
    }
}