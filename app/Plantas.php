<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idPlanta
 * @property int $idTipoPlanta
 * @property string $nombre
 * @property int $cantidad
 * @property float $valor
 * @property string $created_at
 * @property string $updated_at
 * @property TipoPlantum $tipoPlantum
 * @property DetalleEntrada[] $detalleEntradas
 * @property DetalleSalida[] $detalleSalidas
 * @property DetalleSolicitud[] $detalleSolicituds
 */
class Plantas extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idPlanta';

    /**
     * @var array
     */
    protected $fillable = ['idPlanta','idTipoPlanta', 'nombre', 'cantidad', 'valor', 'created_at', 'updated_at'];

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
    public function detalleEntrada()
    {
        return $this->hasMany('App\DetalleEntradas', 'idPlanta', 'idPlanta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleSalida()
    {
        return $this->hasMany('App\DetalleSalida', 'idPlanta', 'idPlanta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleSolicitud()
    {
        return $this->hasMany('App\DetalleSolicitud', 'idPlanta', 'idPlanta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleSeccion()
    {
        return $this->hasMany('App\DetalleSeccion', 'idPlanta', 'idPlanta');
    }
}
