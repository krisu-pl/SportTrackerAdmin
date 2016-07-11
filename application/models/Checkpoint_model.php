<?php
class Checkpoint_model extends CI_Model
{
    const CHECKPOINTS_PARTICIPANTS = 'connect_participants_checkpoints';
    const CHECKPOINTS = 'checkpoints';
    const EVENTS = 'events';

    /**
     * Returns participants' times from a given checkpoint
     *
     * @param $checkpointId
     * @return checkpoints
     */
    public function getCheckpointTimes($checkpointId){
        $query = $this->db
            ->get_where(self::CHECKPOINTS_PARTICIPANTS, array(self::CHECKPOINTS_PARTICIPANTS.'.checkpoint_id' => $checkpointId));

        return $query->result();
    }

    /**
     * Returns all checkpoints of a given event
     *
     * @param $eventId
     * @return checkpoints
     */
    public function getForEvent($eventId){
        $query = $this->db
            ->join(self::CHECKPOINTS, self::CHECKPOINTS.'.event_id = '.self::EVENTS.'.id')
            ->order_by('priority', 'ASC')
            ->get_where(self::EVENTS, array(self::EVENTS.'.id' => $eventId));

        return $query->result();
    }
}