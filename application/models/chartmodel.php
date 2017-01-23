<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of ChartModel
 *
 * @author http://roytuts.com
 */
class ChartModel extends CI_Model {

    private $performance = 'performance';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_chart_data() {

        $query = $this->db->get_where('lookup', array('lang_code' => 'en-ru'));

        return $query->result();
    }

}

/* End of file chartmodel.php */
/* Location: ./application/models/chartmodel.php */