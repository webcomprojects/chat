<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infobill extends Model
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
        'made16_status',
        'Two_way_electricity_rate',
        'middle_load_meter_consumption',
        'middle_load_allocation_coefficient',
        'middle_load_electricity_supply_rate',
        'peak_load_meter_consumption',
        'peak_load_allocation_coefficient',
        'peak_load_electricity_supply_rate',
        'low_load_meter_consumption',
        'low_load_allocation_coefficient',
        'low_load_electricity_supply_rate',
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
