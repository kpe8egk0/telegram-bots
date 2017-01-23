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
        //$this->load->database();
    }

    function get_chart_data() {

        /*
        $stmt = $this->db->prepare('SELECT date(date) as day, COUNT(id) AS qty FROM lookup GROUP BY date(date) DESC');
        $stmt->execute();
        $results['chart_data'] = $stmt->fetchAll();
        */
        $results['chart_data'] = array(array('day' => '1', 'qty' => 6), array('day' => '2', 'qty' => 3));

        return $results;
    }

}

/* End of file chartmodel.php */
/* Location: ./application/models/chartmodel.php */