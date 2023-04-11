<?php

require_once 'Model.php';

class Agent extends Model
{
    public function getAll()
    {
        $connection = $this->openMySQL();
        $query = $connection->query("SELECT * FROM `agents`");
        $agents = $query->fetchAll(PDO::FETCH_ASSOC);
        $connection = null;

        return json_encode($agents);
    }

    public function getAgentByB64($b64Code)
    {
        $connection = $this->openMySQL();
        $query = $connection->query("SELECT `id`, `name` FROM `agents` WHERE TO_BASE64(`id`) = '" . $b64Code . "' LIMIT 1");
        try {
            $result = $query->fetch();
            $connection = null;
            return $result;
        } catch (\Exception $e) {
            $connection = null;
            return null;
        }
    }

    public function acceptAgent($idAgent, $idEvent)
    {
        $connection = $this->openMySQL();
        $query = $connection->query("INSERT INTO `agent_events` (`id_agent`, `id_event`) VALUES ('" . $idAgent . "', '" . $idEvent . "')");

        try {
            $query->execute();
            $connection = null;
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}