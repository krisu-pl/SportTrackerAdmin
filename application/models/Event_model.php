<?php
class Event_model extends CI_Model
{
    const EVENTS = 'events';

    /**
     * @return list of all events
     */
    public function getAll(){
        $query = $this->db
            ->order_by('id', 'DESC')
            ->get(self::EVENTS);
        return $query->result();
    }

    /**
     * Returns details of a given event
     * @param $id
     * @return mixed
     */
    public function getDetails($id){
        $query = $this->db
            ->get_where(self::EVENTS, array(self::EVENTS.'.id' => $id));

        return $query->row();
    }
}