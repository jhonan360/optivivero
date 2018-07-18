<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $cedula
 * @property int $user_id
 * @property string $nombres
 * @property string $apellidos
 * @property string $telefono
 * @property string $direccion
 * @property string $imagen
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Perfilamiento extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'perfilamiento';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'cedula';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'nombres', 'apellidos', 'telefono', 'direccion', 'imagen', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
