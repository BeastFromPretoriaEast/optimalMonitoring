<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Meter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MeterController extends Controller
{
    function __construct(Request $request) {
        $this->start_date = ($request->get('start_date')) ? Carbon::createMidnightDate($request->get('start_date')) : Carbon::createMidnightDate();
        $this->end_date  = ($request->get('end_date')) ? Carbon::createMidnightDate($request->get('end_date'))->addDay()->subSecond(1) : Carbon::createMidnightDate()->addDay()->subSecond(1);
        $this->selectedMeters = ($request->get('meters')) ? Meter::whereIn('id', $request->get('meters'))->get() : Meter::all();
        $this->dataPoints = Meter::getDataPoints($this->selectedMeters, $this->start_date, $this->end_date);
        $this->maxDate = (Data::count()) ? Carbon::make(Data::max('reading_time'))->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $this->minDate = (Data::count()) ? Carbon::make(Data::min('reading_time'))->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $this->meters = Meter::all();
        $this->selectedMetersArr = $this->selectedMeters->pluck('id')->toArray();
        $this->dateTimes = Data::getDateTimes($this->start_date);
        $this->benchmark = ($request->get('benchmark')) ?? 50;
    }

    public function createAGraph()
    {
        return view("create-a-graph", [
            "benchmark" => $this->benchmark,
            "data" => json_encode($this->dataPoints),
            "date_times" => json_encode($this->dateTimes),
            "meters" => $this->meters,
            "selected_meters" => $this->selectedMetersArr,
            "start_date" => $this->start_date->format('Y-m-d'),
            "end_date" => $this->end_date->format('Y-m-d'),
            "max_date" => $this->maxDate,
            "min_date" => $this->minDate,
        ]);
    }

    public function graphDisplay()
    {
        return view("graph-display", [
            "benchmark" => $this->benchmark,
            "data" => json_encode($this->dataPoints),
            "date_times" => json_encode($this->dateTimes),
            "selected_meters" => $this->selectedMetersArr,
            "start_date" => $this->start_date->format('F j, Y, g:i a'),
            "end_date" => Data::getLastReadingOfDate($this->meters, $this->end_date)
        ]);
    }
}
