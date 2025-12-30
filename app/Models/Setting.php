<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'default_value',
        'options',
        'is_editable',
    ];

    protected $casts = [
        'options' => 'array',
        'is_editable' => 'boolean',
    ];

    /**
     * Méthodes utiles
     */
    
    // Récupérer une valeur par clé
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }
        
        // Convertir selon le type
        return self::castValue($setting->value, $setting->type);
    }
    
    // Définir une valeur
    public static function set($key, $value)
    {
        $setting = self::where('key', $key)->first();
        
        if ($setting) {
            $setting->update(['value' => $value]);
        } else {
            self::create([
                'key' => $key,
                'value' => $value,
                'type' => 'string',
                'group' => 'general',
                'label' => $key,
            ]);
        }
    }
    
    // Conversion de type
    private static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }
    
    // Récupérer tous les settings d'un groupe
    public static function getGroup($group)
    {
        return self::where('group', $group)->get()->pluck('value', 'key')->toArray();
    }
}