<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SubKriteria
 * @package App\Models
 * @version October 13, 2017, 3:13 pm UTC
 *
 * @property integer kriteria_id
 * @property string nama_sub_kriteria
 */
class SubKriteria extends Model
{
    use SoftDeletes;

    public $table = 'sub_kriterias';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'kriteria_id',
        'nama_sub_kriteria'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'kriteria_id' => 'integer',
        'nama_sub_kriteria' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'kriteria_id' => 'required',
        'nama_sub_kriteria' => 'required'
    ];

          public function kriteria()
          {
              return $this->belongsTo('App\Models\Kriteria', 'kriteria_id', 'id');
          }

          public function expert()
          {
              return $this->belongsTo('App\Models\Expert', 'expert_id', 'id');
          }

          // public function subKriteria()
          // {
          //     return $this->hasMany('App\Models\SubKriteriaSubKriteria', 'sub_kriteria1_id', 'id');
          // }

          public function next(){
              return SubKriteria::where('id', '>', $this->id)->orderBy('id','asc')->first();

          }
          public  function previous(){
              return SubKriteria::where('id', '<', $this->id)->orderBy('id','desc')->first();

          }

}
