<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DownloadLog extends Model
{
    protected $fillable = ['user_id', 'material_id', 'ip_address', 'user_agent'];

    public function user(): BelongsTo     { return $this->belongsTo(User::class); }
    public function material(): BelongsTo { return $this->belongsTo(Material::class); }
}