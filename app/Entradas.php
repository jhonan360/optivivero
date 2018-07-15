<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property int $idEntrada
 * @property int $idSolicitud
 * @property string $fechaHora
 * @property int $cantidadTotal
 * @property float $valorTotal
 * @property string $observacion
 * @property string $created_at
 * @property string $updated_at
 * @property Solicitude $solicitude
 * @property User $user
 * @property DetalleEntrada[] $detalleEntradas
 */
class Entradas extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idEntrada';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'idSolicitud', 'fechaHora', 'cantidadTotal', 'valorTotal', 'observacion', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudes()
    {
        return $this->belongsTo('App\Solicitudes', 'idSolicitud', 'idSolicitud');
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
    public function detalleEntrada()
    {
        return $this->hasMany('App\DetalleEntradas', 'idEntrada', 'idEntrada');
    }
}
