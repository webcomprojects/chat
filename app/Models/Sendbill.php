<?php

namespace App\Models;

use Filament\Forms\Components\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Sendbill extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'name',
        'job',
        'phone',
        'economic_unit',
        'ceo_name',
        'contractual_power',
        'file',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 'pending':
                return '<label class="badge badge-warning p-2">در حال بررسی</label>';
                break;
            case 'confirm':
                return '<label class="badge badge-success p-2">تایید شده</label>';
                break;
            case 'reject':
                return '<label class="badge badge-danger p-2">رد شده</label>';
                break;
            default:
                return '<label class="badge badge-warning p-2">در حال بررسی</label>';
                break;
        }
    }
}
