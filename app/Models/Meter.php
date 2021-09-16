<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    use HasFactory;

    protected $fillable = [
        'color',
        'name',
        'serial_number',
    ];

    public function datas()
    {
        return $this->hasMany(Data::class);
    }

    public static function getDataPoints($meters, $start_date, $end_date)
    {
        $dataPoints = [];

        foreach ($meters as $meter) :
            $meterData = $meter->datas()->orderBy('reading_time','ASC')->whereBetween('reading_time', [$start_date, $end_date])->pluck('meter_value')->toArray();
            $dataPoints[] = array(
                "label" => false,
                "name"  => 'Meter ' . $meter->serial_number,
                "color" => $meter->color,
                "data"  => $meterData,
            );
        endforeach;

        return $dataPoints;
    }
}
