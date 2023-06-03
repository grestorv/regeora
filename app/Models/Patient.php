<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Пациент
 * Class Patient
 * @package App\Models
 * @property int $id
 * @property string first_name
 * @property string last_name
 * @property Carbon birthdate
 * @property string age_type
 * @property int age
 */
class Patient extends Model
{
    use HasFactory;

    public const TABLE = 'patients';

    protected $table = self::TABLE;
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['first_name', 'last_name', 'birthdate', 'age_type', 'age'];
    protected $casts = [
        'birthdate' => 'immutable_date'
    ];
    public const AGE_TYPES = [
        'd' => 'день',
        'm' => 'месяц',
        'y' => 'год',
    ];
}
