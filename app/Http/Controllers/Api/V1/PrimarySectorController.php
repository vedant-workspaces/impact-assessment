<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class PrimarySectorController extends Controller
{
    public function getPrimarySectors()
    {
        return response()->json([
            'data' => [
                ['id' => 1, 'value' => 'Accidents & Traffic Safety'],
                ['id' => 2, 'value' => 'Agriculture Food & Nutrition'],
                ['id' => 3, 'value' => 'Animals & Wildlife'],
                ['id' => 4, 'value' => 'Arts & Culture'],
                ['id' => 5, 'value' => 'Business & Industry'],
                ['id' => 6, 'value' => 'Children'],
                ['id' => 7, 'value' => 'Civil Society Development'],
                ['id' => 8, 'value' => 'Community Development'],
                ['id' => 9, 'value' => 'Democracy & Good Governance'],
                ['id' => 10, 'value' => 'Disability'],
                ['id' => 11, 'value' => 'Economic Development'],
                ['id' => 12, 'value' => 'Education'],
                ['id' => 13, 'value' => 'Employment & Labor'],
                ['id' => 14, 'value' => 'Environment'],
                ['id' => 15, 'value' => 'Family'],
                ['id' => 16, 'value' => 'Health'],
                ['id' => 17, 'value' => 'HIV/AIDS'],
                ['id' => 18, 'value' => 'Housing & Shelter'],
                ['id' => 19, 'value' => 'Human Rights'],
                ['id' => 20, 'value' => 'Human Service'],
                ['id' => 21, 'value' => 'Humanitarian Relief'],
                ['id' => 22, 'value' => 'Immigration'],
                ['id' => 23, 'value' => 'Indigenous Communities'],
                ['id' => 24, 'value' => 'Information Technology'],
                ['id' => 25, 'value' => 'International Affairs'],
                ['id' => 26, 'value' => 'LGBTQ'],
                ['id' => 27, 'value' => 'Livelihood'],
                ['id' => 28, 'value' => 'Media'],
                ['id' => 29, 'value' => 'Narcotics Drugs & Crime'],
                ['id' => 30, 'value' => 'Old Age Care'],
                ['id' => 31, 'value' => 'Other/General'],
                ['id' => 32, 'value' => 'Peace & Conflict Resolution'],
                ['id' => 33, 'value' => 'Poverty Alleviation'],
                ['id' => 34, 'value' => 'Public Affairs'],
                ['id' => 35, 'value' => 'Refugee & Asylum Seekers'],
                ['id' => 36, 'value' => 'Religion'],
                ['id' => 37, 'value' => 'Science'],
                ['id' => 38, 'value' => 'Social Sciences'],
                ['id' => 39, 'value' => 'Social Service'],
                ['id' => 40, 'value' => 'Sports & Recreation'],
                ['id' => 41, 'value' => 'Sustainable Development'],
                ['id' => 42, 'value' => 'Tourism & Travel'],
                ['id' => 43, 'value' => 'Volunteerism'],
                ['id' => 44, 'value' => 'Water & Sanitation'],
                ['id' => 45, 'value' => 'Women & Gender'],
                ['id' => 46, 'value' => 'Youth & Adolescents']
            ],
            'status_code' => 200
        ]);
    }
}