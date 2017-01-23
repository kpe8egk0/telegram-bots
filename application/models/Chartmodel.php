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
    }

    function get_chart_data() {

        $query = $this->db->query('SELECT date(date) as day, COUNT(id) AS qty FROM lookup GROUP BY date(date) DESC');

        return $query->result();
    }

}
