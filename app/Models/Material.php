<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'institute_id',
        'department_id',
        'semester',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'uploaded_by',
        'views',
        'downloads',
        'description',
    ];

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function incrementDownloads(): void
    {
        $this->increment('downloads');
    }
}
