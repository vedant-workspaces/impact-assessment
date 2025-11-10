<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class SdgsController extends Controller
{
    public function getSdgs()
    {
        return response()->json([
            'data' => [
                ['id' => 1, 'value' => 'No Poverty'],
                ['id' => 2, 'value' => 'Zero Hunger'],
                ['id' => 3, 'value' => 'Good Health and Well-being'],
                ['id' => 4, 'value' => 'Quality Education'],
                ['id' => 5, 'value' => 'Gender Equality'],
                ['id' => 6, 'value' => 'Clean Water and Sanitation'],
                ['id' => 7, 'value' => 'Affordable and Clean Energy'],
                ['id' => 8, 'value' => 'Decent Work and Economic Growth'],
                ['id' => 9, 'value' => 'Industry, Innovation and Infrastructure'],
                ['id' => 10, 'value' => 'Reduced Inequalities'],
                ['id' => 11, 'value' => 'Sustainable Cities and Communities'],
                ['id' => 12, 'value' => 'Responsible Consumption and Production'],
                ['id' => 13, 'value' => 'Climate Action'],
                ['id' => 14, 'value' => 'Life Below Water'],
                ['id' => 15, 'value' => 'Life on Land'],
                ['id' => 16, 'value' => 'Peace, Justice and Strong Institutions'],
                ['id' => 17, 'value' => 'Partnerships for the Goals'],
            ],
            'status_code' => 200
        ]);
    }
}