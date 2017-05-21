<?php
namespace Snippet\Models;

use Phalcon\Mvc\Model;

class UserDetails extends Model
{
    public $id;
    public $user_id;
    public $firstname;
    public $lastname;
    public $country;
    public $created_at;
    public $updated_at;

    public function initialize()
    {
        $this->belongsTo('user_id', 'Snippet\Models\Users', 'id');
        $this->addBehavior(new Timestampable([
            'beforeCreate' => [
                'field' => 'created_at',
                'format' => "Y-m-d H:i:s",
            ]
        ]));

        $this->addBehavior(new Timestampable([
            'beforeUpdate' => [
                'field' => 'updated_at',
                'format' => "Y-m-d H:i:s",
            ]
        ]));
    }
}
