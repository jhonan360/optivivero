<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $solicitudes_idSolicitud
 * @property int $plantas_idPlanta
 * @property int $cantidad
 * @property float $valor
 * @property string $created_at
 * @property string $updated_at
 * @property Planta $planta
 * @property Solicitude $solicitude
 */
class DetalleSolicitud extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detalleSolicitud';

    /**
     * @var array
     */
    protected $fillable = ['idSolicitud','idPlanta','cantidad', 'valor', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planta()
    {
        return $this->belongsTo('App\Plantas', 'idPlanta', 'idPlanta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudes()
    {
        return $this->belongsTo('App\Solicitudes', 'idSolicitud', 'idSolicitud');
    }
}
