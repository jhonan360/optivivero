<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reportes extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idReporte';
    /**
     * @var array
     */
    protected $fillable = ['idReporte', 'tipo', 'consecutivo', 'created_at', 'updated_at'];
}
