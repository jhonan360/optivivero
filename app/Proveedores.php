<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idProveedor
 * @property string $nit
 * @property string $razonSocial
 * @property string $telefono
 * @property string $direccion
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 * @property Solicitude[] $solicitudes
 */
class Proveedores extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idProveedor';

    /**
     * @var array
     */
    protected $fillable = ['nit', 'razonSocial', 'telefono', 'direccion','created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudes()
    {
        return $this->hasMany('App\Solicitudes', 'idProveedor', 'idProveedor');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
