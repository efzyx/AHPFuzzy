<?php

namespace App\Repositories;

use App\Models\Pemasok;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PemasokRepository
 * @package App\Repositories
 * @version October 16, 2017, 10:45 pm UTC
 *
 * @method Pemasok findWithoutFail($id, $columns = ['*'])
 * @method Pemasok find($id, $columns = ['*'])
 * @method Pemasok first($columns = ['*'])
*/
class PemasokRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nama_pemasok'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Pemasok::class;
    }
}
