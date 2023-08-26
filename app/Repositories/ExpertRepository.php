<?php

namespace App\Repositories;

use App\Models\Expert;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ExpertRepository
 * @package App\Repositories
 * @version October 13, 2017, 4:37 pm UTC
 *
 * @method Expert findWithoutFail($id, $columns = ['*'])
 * @method Expert find($id, $columns = ['*'])
 * @method Expert first($columns = ['*'])
*/
class ExpertRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nama'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Expert::class;
    }
}
