<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SubKriteriaSubKriteria
 * @package App\Models
 * @version October 14, 2017, 8:42 pm UTC
 *
 * @property integer sub_kriteria1_id
 * @property integer sub_kriteria2_id
 * @property integer expert_id
 * @property integer nilai
 */
class SubKriteriaSubKriteria extends Model
{
    use SoftDeletes;

    public $table = 'sub_kriteria_sub_kriterias';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'sub_kriteria1_id',
        'sub_kriteria2_id',
        'expert_id',
        'nilai',
        'kriteria_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'sub_kriteria1_id' => 'integer',
        'sub_kriteria2_id' => 'integer',
        'expert_id' => 'integer',
        'nilai' => 'float',
        'kriteria_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'sub_kriteria1_id' => 'required',
        'sub_kriteria2_id' => 'required',
        'expert_id' => 'required',
        'nilai' => 'required',
        'kriteria_id' => 'required'
    ];

    // public function kriteria(){
    //   return $this->hasManyThrough('App\Models\Kriteria', 'App\Models\Kriteria');
    // }

    public function expert()
    {
        return $this->belongsTo('App\Models\Expert', 'expert_id', 'id');
    }
}
