<?php
$Config = [
    'comics_sections' => [
        ['id' => 1, 'title' => 'უახლესი', 'sortBy' => 'published DESC'],
        ['id' => 2, 'title' => 'ყველაზე ნახვადი', 'sortBy' => 'peopleRating DESC', 'condition' => 'peopleRating > 0'],
        ['id' => 3, 'title' => 'უფასო კომიქსები', 'sortBy' => 'price DESC', 'condition' => 'price = 0'],
    ]
];