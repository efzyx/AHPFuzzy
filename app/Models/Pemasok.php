<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $nama_pemasok
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Pemasok extends Model
{
    use SoftDeletes;

    protected $table = 'pemasoks';

    protected $fillable = [
        'nama_pemasok',
    ];

    protected $casts = [
        'nama_pemasok' => 'string',
        'deleted_at' => 'datetime',
    ];

    public static array $rules = [
        'nama_pemasok' => 'required|string|max:255',
    ];
}
