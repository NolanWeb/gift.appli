<?php

namespace gift\appli\core\domain\entities;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Prestation extends Eloquent
{
    protected $table = 'prestation';
    protected $fillable = ['libelle', 'description', 'unite', 'tarif', 'img', 'cat_id'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    public $keyType = 'string';

    public function categorie()
    {
        return $this->belongsTo('gift\appli\core\domain\entities\Categorie', 'cat_id');
    }

    public function box()
    {
        return $this->belongsToMany(
            'gift\appli\core\domain\entities\Box',
            'box2presta',
            'presta_id',
            'box_id'
        )
            ->withPivot(['quantite']);
    }
}
