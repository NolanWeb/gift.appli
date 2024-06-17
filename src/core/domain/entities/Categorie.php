<?php

namespace gift\appli\core\domain\entities;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Eloquent
{
    protected $fillable = ['libelle', 'description'];
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function prestations(): HasMany
    {
        return $this->hasMany('gift\appli\core\domain\entities\Prestation', 'cat_id');
    }
}