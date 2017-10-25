<?php

namespace App\Repositories;

use App\Models\SubKriteria;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SubKriteriaRepository
 * @package App\Repositories
 * @version October 13, 2017, 3:13 pm UTC
 *
 * @method SubKriteria findWithoutFail($id, $columns = ['*'])
 * @method SubKriteria find($id, $columns = ['*'])
 * @method SubKriteria first($columns = ['*'])
*/
class SubKriteriaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'kriteria_id',
        'nama_sub_kriteria'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SubKriteria::class;
    }
}
