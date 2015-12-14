<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

require_once("initialize.php");
require_once(RET_LIB_PATH.DS.'database.php');

global $database;

$data = array(
    'results' => array(),
    'success' => false,
    'error' => ''
);

if (isset($_POST['first-name']) && isset($_POST['last-name'])) {
    $first_name = $database->escape_value(trim($_POST['first-name']));
    $last_name = $database->escape_value(trim($_POST['last-name']));
    $supervisor_query = "SELECT first_name, last_name FROM supervisor WHERE applicant_first = '$first_name' AND applicant_last = '$last_name'";
    $references_query = "SELECT first_name, last_name FROM reference WHERE applicant_first = '$first_name' AND applicant_last = '$last_name'";
    $supervisor_result = $database->query($supervisor_query);
    $references_result = $database->query($references_query);
    if (!$supervisor_result && !$references_result)
        $data['error'] = "We're experiencing an issue with our server. Abandon ship!";
    else {
        while ($row = $supervisor_result->fetch_assoc()) {
            $data['results'][] = array(
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name']
            );
        }
        while ($row = $references_result->fetch_assoc()) {
            $data['results'][] = array(
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name']
            );
        }
        $data['success'] = true;
    }
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode((object)$data);
