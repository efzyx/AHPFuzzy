<?php

namespace App\Repositories;

use App\Models\PemasokSub;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PemasokSubRepository
 * @package App\Repositories
 * @version October 17, 2017, 12:19 am UTC
 *
 * @method PemasokSub findWithoutFail($id, $columns = ['*'])
 * @method PemasokSub find($id, $columns = ['*'])
 * @method PemasokSub first($columns = ['*'])
*/
class PemasokSubRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pemasok1_id',
        'nilai',
        'pemasok2_id',
        'kriteria_id',
        'expert_id',
        'sub_kriteria_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PemasokSub::class;
    }
}
