<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author http://roytuts.com
 */
class ChartController extends CI_Controller {

    public function __construct() {
        parent::__construct();

    }

    public function index() {
        $this->load->model('chartmodel');
        $results = $this->chartmodel->get_chart_data();
        $data['chart_data'] = $results;
        $this->load->view('chart', $data);//, $data);
    }

}

/* End of file ChartController.php */
/* Location: ./application/controllers/ChartController.php */