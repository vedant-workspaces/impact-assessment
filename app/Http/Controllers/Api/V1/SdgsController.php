<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class SdgsController extends Controller
{
    public function getSdgs()
    {
        return response()->json([
            'data' => [
                ['id' => 1, 'sdg_name' => 'No Poverty'],
                ['id' => 2, 'sdg_name' => 'Zero Hunger'],
                ['id' => 3, 'sdg_name' => 'Good Health and Well-being'],
                ['id' => 4, 'sdg_name' => 'Quality Education'],
                ['id' => 5, 'sdg_name' => 'Gender Equality'],
                ['id' => 6, 'sdg_name' => 'Clean Water and Sanitation'],
                ['id' => 7, 'sdg_name' => 'Affordable and Clean Energy'],
                ['id' => 8, 'sdg_name' => 'Decent Work and Economic Growth'],
                ['id' => 9, 'sdg_name' => 'Industry, Innovation and Infrastructure'],
                ['id' => 10, 'sdg_name' => 'Reduced Inequalities'],
                ['id' => 11, 'sdg_name' => 'Sustainable Cities and Communities'],
                ['id' => 12, 'sdg_name' => 'Responsible Consumption and Production'],
                ['id' => 13, 'sdg_name' => 'Climate Action'],
                ['id' => 14, 'sdg_name' => 'Life Below Water'],
                ['id' => 15, 'sdg_name' => 'Life on Land'],
                ['id' => 16, 'sdg_name' => 'Peace, Justice and Strong Institutions'],
                ['id' => 17, 'sdg_name' => 'Partnerships for the Goals'],
            ],
            'status_code' => 200
        ]);
    }
}