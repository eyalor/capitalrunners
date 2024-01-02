<?php
/*
 * Created on May 21, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 require_once 'ajax_page_init.php';

 $runner_id = $memberAuthentication->getMemberId();
 $admin = $memberAuthentication->isAdmin();
 $coach = $memberAuthentication->isCoach();
 $validationResult = validatePositiveInt($runner_id);
 if (!$validationResult->isValid()) {
     die(getErrorStatusWithDummyData("Invalid runner id: " . $validationResult->getMessage()));
 }
 

try {
    $conn = getConnection();
    echo getUsersRecords($conn,$runner_id);
    $conn = null;
} catch (PDOException $e) {
    die(getErrorStatusWithDummyData($e->getMessage()));
}

function getUsersRecords($conn,$runner_id)  {

    if ($_SESSION[MEMBER_ADMIN_SESSION_KEY_NAME]){
                $sql = "SELECT tl_runners.id as user_id, tl_runners.member_name as member_name,tl_runners.member_num as member_num, tl_runners.email as email, tl_runners.birthday as birthdate, tl_runners.m_show_profile as active_runner FROM  tl_runners order by tl_runners.m_show_profile DESC,tl_runners.member_name";
            }
    else {    
                 $sql = "SELECT tl_runners.id as user_id, tl_runners.member_name as member_name,tl_runners.member_num as member_num, tl_runners.email as email, tl_runners.birthday as birthdate, tl_runners.m_show_profile as active_runner FROM tl_runners WHERE tl_runners.id = '" . $runner_id . "'";
    }
    //$sql = "SELECT tl_runners.id as user_id, tl_runners.member_name as member_name,tl_runners.member_num as member_num, tl_runners.email as email, tl_runners.birthday as birthdate, tl_runners.m_show_profile as active_runner FROM  tl_runners order by tl_runners.m_show_profile DESC,tl_runners.member_name";
    //$sql = "SELECT tl_runners.id as user_id, tl_runners.member_name as member_name,tl_runners.member_num as member_num, tl_runners.email as email, tl_runners.birthday as birthdate, tl_runners.m_show_profile as active_runner FROM tl_runners WHERE tl_runners.id = '" . $runner_id . "'";
    $stmt = $conn->query($sql);
    $result = $stmt->fetchAll(PDO :: FETCH_ASSOC);
    // loop over the result and get the shoe distance  for each shoe
    return returnJSONsuccess($result);
}
?>