<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsumerController extends Controller
{
    public function get_data()
    {
        return request()->all();
    }
    public function get_data2()
    {
        return [
            'name' => 'sumerthin',
            'roll' => 'adsfsad',
        ];
    }
}
