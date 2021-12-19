<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAppoinment extends Model
{
    use HasFactory;

    protected $appends = [
        'total_time',
        // 'time_diff_from_doctor_start_time',
        'time_range',
        'time_slot',
        'formatted_start_time',
        'formatted_end_time',
        'formatted_date',
        'startDate',
        'endDate',
        'title',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    public function consumer()
    {
        return $this->belongsTo(User::class, 'consumer_id');
    }

    public function getTimeDiffFromDoctorStartTimeAttribute()
    {
        $date = session()->get('user_appoinment_date');
        $day = $date->format('l');
        $start_time = null;
        $end_time = null;
        $minute_diff_from_doctor_start_time = 0;
        $consumer_start_time = Carbon::parse($this->start_time);

        if (UserDoctorInformaion::where('doctor_id', $this->doctor_id)->exists()) {
            $doctor_info = UserDoctorInformaion::where('doctor_id', $this->doctor_id)->first();
            $schedule = json_decode($doctor_info->schedule);
            foreach ($schedule as $item) {
                if (strtolower($item->day)  == strtolower($day)) {
                    $start_time = Carbon::parse($item->start_time);
                    $end_time = Carbon::parse($item->end_time);
                    // $minute_diff_from_doctor_start_time = $end_time->diffInSeconds($start_time) / 60;
                    $minute_diff_from_doctor_start_time = $consumer_start_time->diffInSeconds($start_time) / 60;
                }
            }
        }

        return [
            'appoinment_date' => $date,
            'appoinment_day' => $day,
            'consumer_start_time' => $consumer_start_time,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'minute_diff_from_doctor_start_time' => $minute_diff_from_doctor_start_time,
        ];
    }

    public function getTimeSlotAttribute()
    {
        return Carbon::parse($this->start_time)->format('h:00 a');
    }

    public function getTimeRangeAttribute()
    {
        return Carbon::parse($this->start_time)->format('h:i a') .' - '. Carbon::parse($this->end_time)->format('h:i a');
    }

    public function getFormattedStartTimeAttribute()
    {
        return Carbon::parse($this->start_time)->format('h:i a');
    }

    public function getTitleAttribute()
    {
        return $this->consumer->displayName;
    }

    public function getStartDateAttribute()
    {
        return Carbon::parse($this->date.' '.$this->start_time)->format('D M d Y H:i:s');
    }

    public function getEndDateAttribute()
    {
        return Carbon::parse($this->date.' '.$this->end_time)->format('D M d Y H:i:s');
    }

    public function getFormattedEndTimeAttribute()
    {
        return Carbon::parse($this->end_time)->format('h:i a');
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->date)->format('d F Y, l');
    }

    public function getTotalTimeAttribute()
    {
        if ($this->start_time && $this->end_time) {
            return Carbon::parse($this->end_time)->diffInSeconds(Carbon::parse($this->start_time)) / 60;
        } else {
            return 0;
        }
    }
}
