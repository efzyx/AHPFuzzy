<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $nama_kriteria
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Kriteria extends Model
{
    use SoftDeletes;

    protected $table = 'kriterias';

    protected $fillable = [
        'nama_kriteria',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public static array $rules = [
        'nama_kriteria' => 'required|string|max:255',
    ];

    public function next(): ?self
    {
        return self::where('id', '>', $this->id)
            ->orderBy('id', 'asc')
            ->first();
    }

    public function previous(): ?self
    {
        return self::where('id', '<', $this->id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function subKriteria(): HasMany
    {
        return $this->hasMany(SubKriteria::class, 'kriteria_id');
    }

    public function expert(): HasMany
    {
        return $this->hasMany(Expert::class, 'kriteria_id');
    }
}
