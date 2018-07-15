<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $plantas_idPlanta
 * @property int $entradas_idEntrada
 * @property int $cantidad
 * @property float $valor
 * @property string $created_at
 * @property string $updated_at
 * @property Entrada $entrada
 * @property Planta $planta
 */
class DetalleEntradas extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detalleEntradas';

    /**
     * @var array
     */
    protected $fillable = ['cantidad', 'valor', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entrada()
    {
        return $this->belongsTo('App\Entrada', 'entradas_idEntrada', 'idEntrada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planta()
    {
        return $this->belongsTo('App\Plantas', 'idPlanta', 'idPlanta');
    }
}
