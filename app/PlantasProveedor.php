<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantasProveedor extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plantasProveedor';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idPlanta';

    /**
     * @var array
     */
    protected $fillable = ['idTipoPlanta', 'nombre',  'valor', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoPlanta()
    {
        return $this->belongsTo('App\TipoPlantaProveedor', 'idTipoPlanta', 'idTipoPlanta');
    }
}
