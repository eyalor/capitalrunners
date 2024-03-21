<?php

/*
 * Created on Apr 4, 2012
 *
 * Updating an exisiting event
 * Expecting one JSON string as input  - 'event_fields'
 */
require_once 'ajax_page_init.php';
require_once 'ValidationResult.php';
require_once 'event_common.php';

$eventFields = getEventFields();
//
// Make sure we have the 'event_id'
//
$event_id = $eventFields-> {"event_id" };
if (!isset ($event_id)) {
    die(getErrorStatusWithDummyData("Mandatory input - event_id was not found."));
}

//
// Validate common (common for Create/Update event) fields
//
$validationResult = validateEventFields($eventFields);
if(!$validationResult->isValid()) {
    die(getErrorStatusWithDummyData("Invalid field value: " . $validationResult->getMessage()));
}

//
// Invoke SQL UPDATE
//
try {
    $conn = getConnection();
    $sql = "UPDATE  tl_events  SET run_type_id=?,pulse=?,max_pulse=?,elevation=?,weight=?,warmup_time=?,run_time=?,cooldown_time=?,warmup_distance=?,run_distance=?,cooldown_distance=?,notes=?,shoe_id=?,extra_shoe_id=?,course_id=?,rpe_id=?, race_id=? WHERE id=?";
    //$sql = "UPDATE tl_events  SET run_type_id=?,warmup_time=? WHERE id=?";

    $sth = $conn->prepare($sql);

    $ok = $sth->execute(array (
        (int)$eventFields->{"run_type_id"},
        (int)$eventFields->{"pulse"},
		(int)$eventFields->{"max_pulse"},
		(int)$eventFields->{"elevation"},
		$eventFields->{"weight"},
        0,
        (int)$eventFields->{"run_time"},
        0,
        $eventFields->{"extra_run_distance"},
        $eventFields->{"run_distance"},
        0,
        $eventFields->{"notes"},
        (int)$eventFields->{"shoe_id"},
        (int)$eventFields->{"extra_shoe_id"},
        (int)$eventFields->{"course_id"},
        (int)$eventFields->{"rpe"},
        (int)$eventFields->{"race_id"},
        (int)$eventFields->{"event_id"},    

    ));



    if (!$ok) {
        die(getErrorStatusWithDummyData("Failed to update table."));
    } else {
        echo returnJSONsuccess("");
    }
    $conn = null;
} catch (PDOException $e) {
    die(getErrorStatusWithDummyData($e->getMessage()));
}

// OK - now we have a valid input - lets try to update the race data based on the event from DB
try {
    $conn = getConnection();
    $sql2 = 'INSERT INTO tl_races_data (race_id,runner_id,run_time) VALUES (:race_id,:runner_id,:run_time) ON DUPLICATE KEY UPDATE run_time=:run_time';
    $sth2 = $conn->prepare($sql2);

    $ok = $sth2->execute(array (
        ':run_time' => $eventFields->{"run_time"},
        ':runner_id' => $eventFields->{"runner_id"},
        ':race_id' => $eventFields->{"race_id"},
    ));

    if (!$ok) {
        die(getErrorStatusWithDummyData("Failed to Update Race based on Event."));
    } else {
        echo returnJSONsuccess("");
    }
    $conn = null;
} catch (PDOException $e) {
    die(getErrorStatusWithDummyData($e->getMessage()));
}
