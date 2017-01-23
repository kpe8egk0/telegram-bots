<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author http://roytuts.com
 */
class ChartController extends CI_Controller {

    public function index() {
        //$this->load->model('chartmodel');
        //$results = $this->chartmodel->get_chart_data();
        $results['chart_data'] = array('0' => array('day' => '1', 'qty' => 6), '1' => array('day' => '2', 'qty' => 3));
        $data['chart_data'] = $results['chart_data'];
        $this->load->view('chart', $data);//, $data);
    }

}

/* End of file ChartController.php */
/* Location: ./application/controllers/ChartController.php */