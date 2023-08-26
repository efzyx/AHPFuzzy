<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PemasokSub
 * @package App\Models
 * @version October 17, 2017, 12:19 am UTC
 *
 * @property integer pemasok1_id
 * @property float nilai
 * @property integer pemasok2_id
 * @property integer kriteria_id
 */
class PemasokSub extends Model
{
    use SoftDeletes;

    public $table = 'pemasok_subs';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'pemasok1_id',
        'nilai',
        'pemasok2_id',
        'kriteria_id',
        'expert_id',
        'sub_kriteria_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'pemasok1_id' => 'integer',
        'nilai' => 'float',
        'pemasok2_id' => 'integer',
        'kriteria_id' => 'integer',
        'expert_id' => 'integer',
        'sub_kriteria_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'pemasok1_id' => 'required',
        'nilai' => 'required',
        'pemasok2_id' => 'required',
        'kriteria_id' => 'required',
        'expert_id' => 'required',
        'sub_kriteria_id' => 'required'
    ];

    public function kriteria()
    {
        return $this->belongsTo('App\Models\Kriteria', 'kriteria_id', 'id');
    }

    public function expert()
    {
        return $this->belongsTo('App\Models\Expert', 'expert_id', 'id');
    }

    public function subKriteria(){
      return $this->belongsTo('App\Models\SubKriteria', 'sub_kriteria_id', 'id');
    }
}
