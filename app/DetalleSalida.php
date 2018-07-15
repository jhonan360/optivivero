<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $plantas_idPlanta
 * @property int $salidas_idSalidas
 * @property int $cantidad
 * @property float $valor
 * @property string $created_at
 * @property string $updated_at
 * @property Planta $planta
 * @property Salida $salida
 */
class DetalleSalida extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detalleSalida';

    /**
     * @var array
     */
    protected $fillable = ['cantidad', 'valor', 'created_at', 'updated_at'];

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
    public function salida()
    {
        return $this->belongsTo('App\Salidas', 'idSalidas', 'idSalidas');
    }
}
