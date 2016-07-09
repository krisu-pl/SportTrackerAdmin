<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Simulate extends CI_Controller {

    /**
     * Simple dropdown with list of events
     */
    public function index()
    {
        $this->load->model('event_model');

        $data['events'] = $this->event_model->getAll();

        // Load view
        $data['custom_view'] = true;
        $data['output'] = $this->load->view('simulate-choose_event', $data, true);
        $this->load->view('panel', $data);
    }

    /**
     * Show page of an event with a given id
     * @param $id
     */
    public function event($id)
    {
        $this->load->model('event_model');
        $this->load->model('checkpoint_model');

        // Get event details (name, start date)
        $event = $this->event_model->getDetails($id);

        if($event == null)
            show_404();

        // Get data of participants in the event
        $participants = $this->event_model->getParticipants($id);

        // Get checkpoints of the event
        $checkpoints = $this->event_model->getCheckpoints($id);

        // Get times for each checkpoint
        // Indexes of the returned array are checkpoints ids.
        $checkpointsData = array();
        foreach ($checkpoints as $checkpoint) {
            $checkpointsData[$checkpoint->id] = $this->checkpoint_model->getCheckpointTimes($checkpoint->id);
        }

        /**
         * For each set of checkpoint data, put each time in the object of a specific participant.
         * We change the arrays from:
         *
         * [checkpoint_id] = {
         *      participant_id = ...
         *      time = ...
         * }
         *
         * to:
         *
         * [participant_id] = {
         *      [checkpoint_id] = time
         * }
         */
        $participantsTimes = array();
        foreach ($checkpointsData as $singleCheckpointData) {
            foreach ($singleCheckpointData as $singleTime) {
                $participantId = $singleTime->participant_id;
                $checkpointId = $singleTime->checkpoint_id;
                unset($singleTime->participant_id);
                $participantsTimes[$participantId][$checkpointId] = $singleTime->time;
            }
        }

        // Merge participants' times with data about them
        foreach ($participants as $participant) {
            if(isset($participantsTimes[$participant->id])) {
                $participant->checkpoints = $participantsTimes[$participant->id];
            }
            else {
                $participant->checkpoints = null;
            }
        }

        // Assign data to variables sent to view
        $data['event'] = $event;
        $data['checkpoints'] = $checkpoints;
        $data['participants'] = $participants;

        // Load views
        $data['custom_view'] = true;
        $data['output'] = $this->load->view('simulate-event_details', $data, true);
        $this->load->view('panel', $data);
    }
}