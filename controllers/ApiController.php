<?php

require_once 'Controller.php';
require_once ROOT_PATH . '/models/Event.php';
require_once ROOT_PATH . '/models/Agent.php';

class ApiController extends Controller
{
    public function getEvents()
    {
        $eventModel = new Event();
        $events = $eventModel->getALl();

        return json_encode($events);
    }

    public function acceptAgentByCode()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $agentModel = new Agent();
        $agent = $agentModel->getAgentByB64($data['code']);

        if ($agent != null) {
            $result = $agentModel->acceptAgent($agent['id'], $data['event']);

            if ($result) {
                return json_encode(['status' => 'success', 'code' => 200, 'data' => $agent]);
            } else {
                return json_encode(['status' => 'fail', 'code' => 500, 'message' => 'Не удалось зарегистрировать агента на мероприятие']);
            }
        }

        return json_encode(['message' => 'Агент с таким кодом не найден.']);
    }
}