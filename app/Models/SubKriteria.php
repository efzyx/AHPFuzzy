<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $kriteria_id
 * @property string $nama_sub_kriteria
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class SubKriteria extends Model
{
    use SoftDeletes;

    protected $table = 'sub_kriterias';

    protected $fillable = [
        'kriteria_id',
        'nama_sub_kriteria',
    ];

    protected $casts = [
        'kriteria_id' => 'integer',
        'nama_sub_kriteria' => 'string',
        'deleted_at' => 'datetime',
    ];

    public static array $rules = [
        'kriteria_id' => 'required|integer|exists:kriterias,id',
        'nama_sub_kriteria' => 'required|string|max:255',
    ];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class, 'expert_id');
    }

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
}
