<?php
class Checkpoint_model extends CI_Model
{
    const CHECKPOINTS_PARTICIPANTS = 'connect_participants_checkpoints';

    /**
     * Gets data of a given checkpoint
     * @param $id
     * @return checkpoints
     */
    public function getCheckpointTimes($id){
        $query = $this->db
            ->get_where(self::CHECKPOINTS_PARTICIPANTS, array(self::CHECKPOINTS_PARTICIPANTS.'.checkpoint_id' => $id));

        return $query->result();
    }
}