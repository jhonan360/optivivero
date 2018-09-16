<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPlantaProveedor extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipoPlantaProveedor';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idTipoPlanta';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'imagen', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plantas()
    {
        return $this->hasMany('App\PlantasProveedor', 'idTipoPlanta', 'idTipoPlanta');
    }
}