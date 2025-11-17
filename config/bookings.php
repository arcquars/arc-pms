<?php

return [
    'state_colors' => [
        'AVAILABLE' => '#28a745',
        'RESERVATION' => '#146DE5',
        'BUSY' => '#F9A81D',
        'BUSY_CHECKOUT_BACKLOG' => '#E73737',
        'CLEANING' => '#ADD8E6',
        'BLOOKED' => '#808080',
        'MAINTENANCE' => '#808080',
    ],
    'state_icons' => [
        'AVAILABLE' => 'fas fa-bed',
        'RESERVATION' => 'far fa-calendar',
        'BUSY' => 'fas fa-bed',
        'BUSY_CHECKOUT_BACKLOG' => 'fas fa-bed',
        'CLEANING' => 'fas fa-broom',
        'BLOOKED' => 'fas fa-user-lock',
        'MAINTENANCE' => 'fas fa-tools',
    ],
    'booking_status' => [
        'reservation_not_confirmed',
        'reservation_confirmed',
        'income',
        'no_income',
        'hosting_completed',
    ],
    'booking_status_icon' => [
        'reservation_not_confirmed' => 'far fa-calendar',
        'reservation_confirmed' => 'far fa-calendar',
        'income' => 'far fa-clock',
        'no_income' => 'fas fa-tools',
        'hosting_completed' => 'fas fa-bed',
    ],
    // FORWARD_METHOD_PAYMENT
    'method_payment' => [
        'Effective',
        'Transfer',
        'Card'
    ],
    'booking_status_colors' => [
        'reservation_not_confirmed' => '#146DE5',
        'reservation_confirmed' => '#28a745',
        'income' =>  '#fd7e14', //'#fc4b08',
        'no_income' => '#000000',
        'hosting_completed' => '#EFBF04',
    ],
    'discounts' => [
        5,10,15,20,25,30,35
    ],
    'money' => 'Bs',
    'document_type' => [
        'CI',
        'PASAPORTE',
    ],
    'check-in-time' => ['hour' => 14, 'minute' => 1],
    'check-out-time' => ['hour' => 12, 'minute' => 0],

];
