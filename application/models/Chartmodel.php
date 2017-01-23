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

        $db = db();
        $stmt = $db->prepare('SELECT date(date) as day, COUNT(id) AS qty FROM lookup GROUP BY date(date) DESC');
        $stmt->execute();

        $results['chart_data'] = $stmt->execute();

        return $results;
    }

}
