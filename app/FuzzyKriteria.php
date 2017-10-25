<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FuzzyKriteria extends Model
{
  use SoftDeletes;

  public $table = 'fuzzy_kriterias';


  protected $dates = ['deleted_at'];


  public $fillable = [
      'data'
  ];

  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'data' => 'string'
  ];

  /**
   * Validation rules
   *
   * @var array
   */
  public static $rules = [
      'data' => 'required'
  ];
}
