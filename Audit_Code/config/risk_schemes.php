<?php

return [
    // “None” — let your built-in methodology apply automatically
    'none' => [
        'label' => 'None (Methodology default)',
        'values' => [1, 5, 10],
        'map' => [
            1 => ['label' => 'Low',   'class' => 'text-success'],
            5 => ['label' => 'Medium', 'class' => 'text-warning'],
            10 => ['label' => 'High',   'class' => 'text-danger'],
        ],
        'named' => true,
    ],

    // Named 3-level
    '3-level' => [
        'label' => '3-Level (High, Medium, Low)',
        'values' => [3, 2, 1], // highest first
        'map' => [
            3 => ['label' => 'High',   'class' => 'text-danger'],
            2 => ['label' => 'Medium', 'class' => 'text-warning'],
            1 => ['label' => 'Low',    'class' => 'text-success'],
        ],
        'named' => true,
    ],

    // Named 5-level
    '5-level' => [
        'label' => '5-Level (Critical, High, Medium, Low, Very Low)',
        'values' => [5, 4, 3, 2, 1],
        'map' => [
            5 => ['label' => 'Critical',  'class' => 'text-danger'],
            4 => ['label' => 'High',      'class' => 'text-danger'],
            3 => ['label' => 'Medium',    'class' => 'text-warning'],
            2 => ['label' => 'Low',       'class' => 'text-success'],
            1 => ['label' => 'Very Low',  'class' => 'text-success'],
        ],
        'named' => true,
    ],

    // Numeric descending 3,2,1
    '3-level-num' => [
        'label' => '3-Level Numeric in descending order (3,2,1)',
        'values' => [3, 2, 1],
        'named' => false,
    ],

    // Numeric descending 5..1
    '5-level-num' => [
        'label' => '5-Level Numeric in descending order (5, 4, 3, 2, 1)',
        'values' => [5, 4, 3, 2, 1],
        'named' => false,
    ],

    // Numeric descending 10..1
    '10-level-num' => [
        'label' => '10-Level Numeric in descending order (10 to 1)',
        'values' => [10, 9, 8, 7, 6, 5, 4, 3, 2, 1],
        'named' => false,
    ],
];
