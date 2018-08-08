<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property int $idSolicitud
 * @property int $idProveedor
 * @property string $nombre
 * @property string $fechaHora
 * @property int $cantidadTotal
 * @property float $valorTotal
 * @property string $obervacion1
 * @property string $observacion2
 * @property string $created_at
 * @property string $updated_at
 * @property Proveedore $proveedore
 * @property User $user
 * @property DetalleSolicitud[] $detalleSolicituds
 * @property Entrada[] $entradas
 * @property EstadosSolicitude[] $estadosSolicitudes
 */
class Solicitudes extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idSolicitud';

    /**
     * @var array
     */
    protected $fillable = ['idSolicitud','user_id', 'idProveedor', 'nombre', 'fechaHora', 'cantidadTotal', 'valorTotal', 'observacion1', 'observacion2', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedore()
    {
        return $this->belongsTo('App\Proveedores', 'idProveedor', 'idProveedor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleSolicituds()
    {
        return $this->hasMany('App\DetalleSolicitud', 'idSolicitud', 'idSolicitud');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entradas()
    {
        return $this->hasMany('App\Entrada', 'idSolicitud', 'idSolicitud');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estadosSolicitudes()
    {
        return $this->hasMany('App\EstadosSolicitude', 'idSolicitud', 'idSolicitud');
    }
}
