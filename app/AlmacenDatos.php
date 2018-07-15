<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idAlmacenDato
 * @property int $idSeccion
 * @property string $tipo
 * @property string $dato
 * @property string $created_at
 * @property string $updated_at
 * @property Seccione $seccione
 */
class AlmacenDatos extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'almacenDatos';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idAlmacenDato';

    /**
     * @var array
     */
    protected $fillable = ['idSeccion', 'tipo', 'dato', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seccion()
    {
        return $this->belongsTo('App\Secciones', 'idSeccion', 'idSeccion');
    }
}
