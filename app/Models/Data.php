<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $fillable = [
        'meter_id',
        'meter_value',
        'reading_time',
    ];

    public function post()
    {
        return $this->belongsTo(Meter::class);
    }

    public static function getDateTimes($start_date)
    {
        $timeRead = Carbon::make($start_date)->startOfDay();
        $dateTimes = [];

        for ($x = 1; $x <= (48 * 7); $x++):
            if($timeRead > Carbon::now()):
                break;
            endif;
            $dateTimes[] = $timeRead->format('H:i | Y-m-d');
            $timeRead->addMinutes(30);
        endfor;

        return $dateTimes;
    }

    public static function getLastReadingOfDate($meters, $end_date) {
        $from = Carbon::make($end_date)->startOfDay()->format('Y-m-d');

        $lastReadingTime = Data::whereIn('meter_id', $meters)->where('reading_time', "<", $from)->max('reading_time');

        return Carbon::make($lastReadingTime)->format('F j, Y, g:i a');
    }
}
