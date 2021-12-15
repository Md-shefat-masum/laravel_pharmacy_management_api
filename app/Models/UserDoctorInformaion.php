<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDoctorInformaion extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = [
        'time_diff_from_doctor_start_time',
    ];

    public function getTimeDiffFromDoctorStartTimeAttribute()
    {
        $date = session()->has('user_appoinment_date') ? session()->get('user_appoinment_date') : Carbon::today();
        $day = $date->format('l');
        $start_time = null;
        $end_time = null;
        $converted_start_time = null;
        $converted_end_time = null;
        $minute_diff_from_doctor_start_time = 0;
        $time_slots = [];

        if (UserDoctorInformaion::where('doctor_id', $this->doctor_id)->exists()) {
            $doctor_info = UserDoctorInformaion::where('doctor_id', $this->doctor_id)->first();
            $schedule = json_decode($doctor_info->schedule);
            foreach ($schedule as $item) {
                if (strtolower($item->day)  == strtolower($day)) {
                    $start_time = Carbon::parse($item->start_time);
                    $end_time = Carbon::parse($item->end_time);
                    $minute_diff_from_doctor_start_time = $end_time->diffInSeconds($start_time) / 60;

                    $converted_start_time = (float) $start_time->format('H') . '.' . (int)(100 * (int) $start_time->format('i') / 60);
                    $converted_end_time = (float) $end_time->format('H') . '.' . (int)(100 * (int) $end_time->format('i') / 60);
                }
            }

            for ($i = (int) $converted_start_time ; $i <= (int) $converted_end_time; $i++) {
                array_push($time_slots, Carbon::parse($i.':00')->format('h:i a'));
            }
        }

        return [
            'appoinment_date' => $date,
            'appoinment_day' => $day,
            'start_time' => $start_time ? $start_time->format('h:i a') : '',
            'end_time' => $end_time ? $end_time->format('h:i a') : '',
            'converted_start_time' => $converted_start_time,
            'converted_end_time' => $converted_end_time,
            'minute_diff_from_doctor_start_time' => $minute_diff_from_doctor_start_time,
            'time_slots' => $time_slots,
        ];
    }
}
