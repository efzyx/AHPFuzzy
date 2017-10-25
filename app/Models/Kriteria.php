<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Kriteria
 * @package App\Models
 * @version October 13, 2017, 3:08 pm UTC
 *
 * @property varchar nama_kriteria
 */
class Kriteria extends Model
{
    use SoftDeletes;

    public $table = 'kriterias';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'nama_kriteria'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nama_kriteria' => 'required'
    ];

    public function next(){
        return Kriteria::where('id', '>', $this->id)->orderBy('id','asc')->first();

    }
    public  function previous(){
        return Kriteria::where('id', '<', $this->id)->orderBy('id','desc')->first();

    }

    public function subKriteria()
   {
       return $this->hasMany('App\Models\SubKriteria', 'kriteria_id', 'id');
   }

  public function expert()
  {
      return $this->hasMany('App\Models\Expert', 'kriteria_id', 'id');
  }
}
