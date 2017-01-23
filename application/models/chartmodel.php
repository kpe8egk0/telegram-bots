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

        $db = db();

        $stmt = $db->prepare('SELECT date(date) as day, COUNT(id) AS qty FROM lookup GROUP BY date(date) DESC');
        $stmt->execute();
        $results['chart_data'] = $stmt->fetchAll();

        return $results;
    }

    function db()
    {
        define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
        define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
        define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
        define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
        define('DB_NAME', getenv('OPENSHIFT_GEAR_NAME'));
        $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8';
        $dbh = new PDO($dsn, DB_USER, DB_PASS);
        return $dbh;
    }

}

/* End of file chartmodel.php */
/* Location: ./application/models/chartmodel.php */