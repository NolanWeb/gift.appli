<?php

namespace gift\appli\core\domain\entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Box extends Eloquent
{
    use HasUuids;
    protected $fillable = ['libelle', 'description', 'kdo', 'message_kdo', 'montant', 'token', 'statut'];
    protected $table = 'box';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;

    public $keyType='string';

    const CREATED = 1;
    public function prestations(): BelongsToMany
    {
        return $this->belongsToMany(
            '\gift\appli\core\domain\entities\Prestation',
            'box2presta',
            'box_id',
            'presta_id'
        );
    }
}
