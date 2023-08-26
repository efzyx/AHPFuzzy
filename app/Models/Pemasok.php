<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Pemasok
 * @package App\Models
 * @version October 16, 2017, 10:45 pm UTC
 *
 * @property string nama_pemasok
 */
class Pemasok extends Model
{
    use SoftDeletes;

    public $table = 'pemasoks';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'nama_pemasok'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nama_pemasok' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nama_pemasok' => 'required'
    ];

    
}
