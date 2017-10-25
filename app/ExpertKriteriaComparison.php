<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ExpertKriteriaComparison extends Model
{
  use SoftDeletes;

  public $table = 'expert_kriteria_comparisons';


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
      'data' => 'longText'
  ];

  /**
   * Validation rules
   *
   * @var array
   */
  public static $rules = [
      'data' => 'required',
  ];
}
