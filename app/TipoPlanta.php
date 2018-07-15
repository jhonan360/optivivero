<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idTipoPlanta
 * @property string $nombre
 * @property string $imagen
 * @property string $created_at
 * @property string $updated_at
 * @property Planta[] $plantas
 * @property Seccione[] $secciones
 */
class TipoPlanta extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipoPlanta';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idTipoPlanta';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'imagen', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plantas()
    {
        return $this->hasMany('App\Planta', 'idTipoPlanta', 'idTipoPlanta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function secciones()
    {
        return $this->hasMany('App\Secciones', 'idTipoPlanta', 'idTipoPlanta');
    }
}
