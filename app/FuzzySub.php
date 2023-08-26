<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FuzzySub extends Model
{
  use SoftDeletes;

  public $table = 'fuzzy_subs';


  protected $dates = ['deleted_at'];


  public $fillable = [
      'kriteria_id',
      'data'
  ];

  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'kriteria_id' => 'integer',
      'data' => 'string'
  ];

  /**
   * Validation rules
   *
   * @var array
   */
  public static $rules = [
      'kriteria_id' => 'required',
      'data' => 'required'
  ];
}
