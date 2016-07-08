<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function _send_output($output = null)
	{
		$this->load->view('panel',$output);
	}

	public function index()
	{
		$this->_send_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

    /*
    ############################################
    ###### EVENTS
    ############################################
    */

    public function events() {
        $crud = new grocery_CRUD();

        $crud->set_table('events');
        $crud->set_subject('event');

        $crud->columns('name', 'start_date','gpx','finished');
        $crud->fields('name', 'start_date', 'gpx', 'finished');

        $crud->required_fields('name','start_date');

        $crud->set_field_upload('gpx','assets/uploads/gpx');
        $crud->callback_after_upload(array($this, 'events_gpx_after_upload_callback'));

        $output = $crud->render();
        $this->_send_output($output);
    }

    public function events_gpx_after_upload_callback($uploader_response, $field_info, $files_to_upload) {
        foreach($files_to_upload as $value) {
            $ext = pathinfo($value['name'], PATHINFO_EXTENSION);
        }
        $allowed_formats = array("gpx");
        if(in_array($ext, $allowed_formats)) {
            return true;
        } else {
            return 'Wrong file format.';
        }
    }

    /*
    ############################################
    ###### CATEGORIES
    ############################################
    */

    public function categories() {
        $crud = new grocery_CRUD();

        $crud->set_table('categories');
        $crud->set_subject('category');

        $crud->columns('name', 'description', 'event_id');
        $crud->required_fields('name','event_id');
        $crud->display_as('event_id', 'Event');

        $crud->set_relation('event_id','events','name');

        $output = $crud->render();
        $this->_send_output($output);
    }


    /*
    ############################################
    ###### CHECKPOINTS
    ############################################
    */

    public function checkpoints() {
        $crud = new grocery_CRUD();

        $crud->set_table('checkpoints');
        $crud->set_subject('checkpoint');

        $crud->columns('name', 'priority', 'event_id');
        $crud->required_fields('name', 'priority', 'event_id');
        $crud->display_as('event_id', 'Event');
        $crud->field_type('priority', 'integer');

        $crud->set_relation('event_id','events','name');

        $output = $crud->render();
        $this->_send_output($output);
    }


    /*
    ############################################
    ###### PARTICIPANTS
    ############################################
    */

    public function participants() {
        $crud = new grocery_CRUD();

        $crud->set_table('participants');
        $crud->set_subject('participant');

        $crud->columns('name', 'team', 'city');
        $crud->required_fields('name');

        $output = $crud->render();
        $this->_send_output($output);
    }

    /*
    ############################################
    ###### ADD TO EVENT
    ############################################
    */

    public function add_to_event() {
        $crud = new grocery_CRUD();

        $this->load->library('gc_dependent_select');

        $crud->set_table('connect_participants_events');
        $crud->set_subject('participant to an event');

        $crud->columns('participant_id', 'event_id', 'category_id', 'starting_number');
        $crud->required_fields('participant_id', 'event_id', 'category_id', 'starting_number');
        $crud->field_type('starting_number', 'integer');

        $crud->set_relation('participant_id', 'participants', 'name');
        $crud->set_relation('event_id', 'events', 'name');
        $crud->set_relation('category_id', 'categories', 'name');

        $crud->display_as('participant_id', 'Participant');
        $crud->display_as('event_id', 'Event');
        $crud->display_as('category_id', 'Category');

        $fields = array(
            'event_id' => array(
                'table_name' => 'events',
                'title' => 'name',
                'relate' => null
            ),
            'category_id' => array(
                'table_name' => 'categories',
                'title' => 'name',
                'id_field' => 'id',
                'relate' => 'event_id',
                'data-placeholder' => 'Select Category'
            )
        );

        $config = array(
            'main_table' => 'events',
            'main_table_primary' => 'id',
            "url" => base_url().'panel/add_to_event/',
            'segment_name' =>'Your_segment_name'
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js;
        $this->_send_output($output);
    }
}