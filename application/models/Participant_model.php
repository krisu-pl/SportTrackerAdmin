<?php
class Participant_model extends CI_Model
{
    const PARTICIPANTS_EVENTS = 'connect_participants_events';
    const EVENTS = 'events';
    const CATEGORIES = 'categories';
    const PARTICIPANTS = 'participants';
    const CHECKPOINTS = 'checkpoints';

    /**
     * Returns participants of a given event
     * @param $id
     * @return participants
     */
    public function getForEvent($id){
        $query = $this->db
            ->select(self::PARTICIPANTS.'.id, '.self::PARTICIPANTS.'.name as participant_name, team, city, starting_number, category_id, '.self::CATEGORIES.'.name as category_name')
            ->join(self::PARTICIPANTS_EVENTS, self::PARTICIPANTS_EVENTS.'.event_id = '.self::EVENTS.'.id')
            ->join(self::PARTICIPANTS, self::PARTICIPANTS.'.id = '.self::PARTICIPANTS_EVENTS.'.participant_id')
            ->join(self::CATEGORIES, self::CATEGORIES.'.id = '.self::PARTICIPANTS_EVENTS.'.category_id')
            ->get_where(self::EVENTS, array(self::EVENTS.'.id' => $id));

        return $query->result();
    }
}