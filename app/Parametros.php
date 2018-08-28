<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametros extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parametros';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'nombre';

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
    protected $fillable = ['dato', 'created_at', 'updated_at'];

}
