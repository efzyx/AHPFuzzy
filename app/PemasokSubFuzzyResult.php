<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PemasokSubFuzzyResult extends Model
{
  use SoftDeletes;

  public $table = 'pemasok_fuzzy_results';


  protected $dates = ['deleted_at'];


  public $fillable = [
      'kriteria_id',
      'data',
      'expert_id',
      'sub_kriteria_id'
  ];

  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
      'kriteria_id' => 'integer',
      'data' => 'longText',
      'expert_id' => 'integer',
      'sub_kriteria_id' => 'integer'
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
