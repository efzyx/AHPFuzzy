<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Expert
 * @package App\Models
 * @version October 13, 2017, 4:37 pm UTC
 *
 * @property string nama
 */
class Expert extends Model
{
    use SoftDeletes;

    public $table = 'experts';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'nama',
        'for'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nama' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nama' => 'required'
    ];


    public function next(){
        return Kriteria::where('id', '>', $this->id)->orderBy('id','asc')->first();

    }
    public  function previous(){
        return Kriteria::where('id', '<', $this->id)->orderBy('id','desc')->first();

    }


    public function sub_kriteria(){
      return $this->hasMany('App\Models\SubKriteria', 'sub_kriteria_id', 'id');
    }

    public function sub_sub_kriteria(){
      return $this->hasMany('App\Models\SubKriteriaSubKriteria', 'expert_id', 'id');
    }
}
