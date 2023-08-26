<?php

namespace App\Repositories;

use App\Models\SubKriteriaSubKriteria;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SubKriteriaSubKriteriaRepository
 * @package App\Repositories
 * @version October 14, 2017, 8:42 pm UTC
 *
 * @method SubKriteriaSubKriteria findWithoutFail($id, $columns = ['*'])
 * @method SubKriteriaSubKriteria find($id, $columns = ['*'])
 * @method SubKriteriaSubKriteria first($columns = ['*'])
*/
class SubKriteriaSubKriteriaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'sub_kriteria1_id',
        'sub_kriteria2_id',
        'expert_id',
        'nilai',
        'kriteria_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SubKriteriaSubKriteria::class;
    }
}
