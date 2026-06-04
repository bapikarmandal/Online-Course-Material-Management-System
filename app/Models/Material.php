<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'institute_id', 'department_id', 'semester',
        'material_type', 'file_path', 'file_name', 'file_type',
        'file_size', 'drive_link', 'uploaded_by', 'views',
        'downloads', 'description', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function institute(): BelongsTo   { return $this->belongsTo(Institute::class); }
    public function department(): BelongsTo  { return $this->belongsTo(Department::class); }
    public function uploader(): BelongsTo    { return $this->belongsTo(User::class, 'uploaded_by'); }
    public function downloadLogs(): HasMany  { return $this->hasMany(DownloadLog::class); }

    public function incrementViews(): void     { $this->increment('views'); }
    public function incrementDownloads(): void { $this->increment('downloads'); }

    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) return 'N/A';
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $i = 0;
        while ($size >= 1024 && $i < 3) { $size /= 1024; $i++; }
        return round($size, 2) . ' ' . $units[$i];
    }
}