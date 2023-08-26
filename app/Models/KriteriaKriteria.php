<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class KriteriaKriteria
 * @package App\Models
 * @version October 13, 2017, 4:51 pm UTC
 *
 * @property integer kriteria1_id
 * @property integer kriteria2_id
 * @property integer expert_id
 * @property double nilai
 */
class KriteriaKriteria extends Model
{
    use SoftDeletes;

    public $table = 'kriteria_kriterias';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'kriteria1_id',
        'kriteria2_id',
        'expert_id',
        'nilai'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'kriteria1_id' => 'integer',
        'kriteria2_id' => 'integer',
        'expert_id' => 'integer',
        'nilai' => 'double'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'kriteria1_id' => 'required',
        'kriteria2_id' => 'required',
        'expert_id' => 'required',
        'nilai' => 'required'
    ];


    public function expert()
    {
        return $this->belongsTo('App\Models\Expert', 'expert_id', 'id');
    }


}
