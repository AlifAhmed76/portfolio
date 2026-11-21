<?php

namespace App\Models;

use App\Models\Concerns\BelongsToWorkspace;
use App\Services\WorkspaceResolver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory, BelongsToWorkspace;

    protected $fillable = [
        'workspace_id',
        'setting_key',
        'setting_value',
        'value_type',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('setting_key', $key)->first();
        if (! $setting) {
            return $default;
        }

        return match ($setting->value_type) {
            'boolean' => filter_var($setting->setting_value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $setting->setting_value,
            'json' => json_decode($setting->setting_value, true),
            default => $setting->setting_value,
        };
    }

    public static function set(string $key, mixed $value, string $type = 'string'): self
    {
        $storedValue = match ($type) {
            'boolean' => $value ? '1' : '0',
            'json' => is_string($value) ? $value : json_encode($value),
            default => (string) $value,
        };

        return static::updateOrCreate(
            ['setting_key' => $key, 'workspace_id' => WorkspaceResolver::currentId()],
            ['setting_value' => $storedValue, 'value_type' => $type]
        );
    }
}
