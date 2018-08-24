<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idSeccion
 * @property int $idTipoPlanta
 * @property string $nombre
 * @property string $observacion
 * @property string $created_at
 * @property string $updated_at
 * @property TipoPlantum $tipoPlantum
 * @property AlmacenDato[] $almacenDatos
 */
class Secciones extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idSeccion';

    /**
     * @var array
     */
    protected $fillable = ['idTipoPlanta', 'nombre','espacioTotal', 'observacion', 'tomarMuestra', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoPlanta()
    {
        return $this->belongsTo('App\TipoPlanta', 'idTipoPlanta', 'idTipoPlanta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function almacenDatos()
    {
        return $this->hasMany('App\AlmacenDato', 'idSeccion', 'idSeccion');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleSeccion()
    {
        return $this->hasMany('App\DetalleSecciones', 'idSeccion', 'idSeccion');
    }
}
