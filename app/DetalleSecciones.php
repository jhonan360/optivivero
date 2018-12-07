<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idPlanta
 * @property int $idSeccion
 * @property int $cantidad
 * @property Planta $planta
 * @property Seccione $seccione
 */
class DetalleSecciones extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detalleSecciones';

    /**
     * @var array
     */
    protected $fillable = ['idPlanta','idSeccion','cantidad'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planta()
    {
        return $this->belongsTo('App\Planta', 'idPlanta', 'idPlanta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seccion()
    {
        return $this->belongsTo('App\Secciones', 'idSeccion', 'idSeccion');
    }
}
