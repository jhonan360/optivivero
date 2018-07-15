<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property int $idSalidas
 * @property string $fechaHora
 * @property int $cantidadTotal
 * @property float $valorTotal
 * @property string $observacion
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property DetalleSalida[] $detalleSalidas
 */
class Salidas extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idSalidas';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'fechaHora', 'cantidadTotal', 'valorTotal', 'observacion', 'created_at', 'updated_at'];

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
    public function detalleSalidas()
    {
        return $this->hasMany('App\DetalleSalida', 'idSalidas', 'idSalidas');
    }
}
