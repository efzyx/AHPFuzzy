<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $nama
 * @property string|null $for
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Expert extends Model
{
    use SoftDeletes;

    protected $table = 'experts';

    protected $fillable = [
        'nama',
        'for',
    ];

    protected $casts = [
        'nama' => 'string',
        'deleted_at' => 'datetime',
    ];

    public static array $rules = [
        'nama' => 'required|string|max:255',
    ];

    public function next(): ?Kriteria
    {
        return Kriteria::where('id', '>', $this->id)
            ->orderBy('id', 'asc')
            ->first();
    }

    public function previous(): ?Kriteria
    {
        return Kriteria::where('id', '<', $this->id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function subKriteria(): HasMany
    {
        return $this->hasMany(SubKriteria::class, 'sub_kriteria_id');
    }

    public function subSubKriteria(): HasMany
    {
        return $this->hasMany(SubKriteriaSubKriteria::class, 'expert_id');
    }
}
