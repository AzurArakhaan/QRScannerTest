<?php

require_once 'Model.php';

class Event extends Model
{
    protected $events = [
        [
            'id' => 0,
            'name' => 'Мероприятие 1',
            'description' => 'Описание мероприятия 1'
        ],
        [
            'id' => 1,
            'name' => 'Мероприятие 2',
            'description' => 'Описание мероприятия 2'
        ]
    ];

    public function getAll()
    {
        $connection = $this->openMySQL();
        $query = $connection->query("SELECT * FROM `events`");
        $events = $query->fetchAll(PDO::FETCH_ASSOC);
        $connection = null;

        return json_encode($events);
    }
}