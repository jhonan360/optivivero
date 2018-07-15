<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idRol
 * @property string $nombre
 * @property string $created_at
 * @property string $updated_at
 * @property User[] $users
 */
class Role extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idRol';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    protected $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'idRol', 'idRol');
    }
}
