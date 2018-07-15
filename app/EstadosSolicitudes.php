<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idEstadoSolicitud
 * @property int $idSolicitud
 * @property string $estado
 * @property string $fechaHora
 * @property string $created_at
 * @property string $updated_at
 * @property Solicitude $solicitude
 */
class EstadosSolicitudes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'estadosSolicitudes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idEstadoSolicitud';

    /**
     * @var array
     */
    protected $fillable = ['idSolicitud', 'estado', 'fechaHora', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudes()
    {
        return $this->belongsTo('App\Solicitudes', 'idSolicitud', 'idSolicitud');
    }
}
