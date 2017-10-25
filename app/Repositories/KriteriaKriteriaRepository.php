<?php

namespace App\Repositories;

use App\Models\KriteriaKriteria;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class KriteriaKriteriaRepository
 * @package App\Repositories
 * @version October 13, 2017, 4:51 pm UTC
 *
 * @method KriteriaKriteria findWithoutFail($id, $columns = ['*'])
 * @method KriteriaKriteria find($id, $columns = ['*'])
 * @method KriteriaKriteria first($columns = ['*'])
*/
class KriteriaKriteriaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'kriteria1_id',
        'kriteria2_id',
        'expert_id',
        'nilai'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return KriteriaKriteria::class;
    }
}
