<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssociatedNameReference extends Model
{
    protected $fillable = ['manga_id', 'assoc_name_id'];

    public function getMangaId()
    {
        return $this->manga_id;
    }

    public function getAssociatedNameId()
    {
        return $this->assoc_name_id;
    }

    public function associatedName()
    {
        return $this->hasOne('App\AssociatedName', 'id', 'assoc_name_id');
    }

    public function manga()
    {
        return $this->belongsTo('App\Manga');
    }
}
