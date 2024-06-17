<?php

namespace gift\appli\core\domain\entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Eloquent
{
    protected $table = 'user';
    protected $fillable = ['id', 'user_id', 'password', 'role'];
}