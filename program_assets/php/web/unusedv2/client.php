<?php
    if(!isset($_SESSION)) { session_start(); } 
    include 'appkey_generator.php';
    include dirname(__FILE__,2) . '/config.php';
    include $main_location . '/connection/conn.php';
    include '../builder/builder_select.php';
    include '../builder/builder_table.php';
    
    $command = $_POST["command"];
    $error   = false;
    $color   = "green";
    $message = "";
    $json    = array();
    
    switch ($command) {
        case "display_client_profile" :
            
            $clientID = $_POST["clientID"];
            
            $sql    = "
                SELECT
                    clientsName,
                    address,
                    contactNumber,
                    contactPerson,
                    emailAddress,
                    landLine
                FROM
                    hris_masterfile_client
                WHERE
                    id = $clientID
            ";
            $result = mysqli_query($con,$sql);
            
            $json = array();
            while ($row  = mysqli_fetch_row($result)) {
                $json[] = array(
                    'clientsName'  => $row[0],
                    'address'  => $row[1],
                    'contactNumber'  => $row[2],
                    'contactPerson'  => $row[3],
                    'emailAddress'  => $row[4],
                    'landLine'  => $row[5]
                );
            }
            echo json_encode($json);
            mysqli_free_result($result);
            
        break;
    
        case "display_area" :
            
            $clientID = $_POST["clientID"];
            
            $sql = "
                SELECT
                    branchName,
                    address,
                    coordinates,
                    id
                FROM
                    hris_mastefile_client_branches
                WHERE
                    isActive = 1
                AND
                    clientID = $clientID
            ";
            return builder($con,$sql);
            
        break;
    
        case "display_assigned_employee" :
            
            $areaID = $_POST["areaID"];
            
            $sql = "
                SELECT
                    b.userID,
                    b.firstName,
                    b.middleName,
                    b.lastName,
                    b.mobileNumber,
                    b.emailAddress,
                    c.position
                FROM
                    hris_area_assignment a
                INNER JOIN
                    hris_user_registration b
                INNER JOIN
                    hris_user_position c
                ON
                    b.positionID = c.id
                WHERE
                    areaID = $areaID
                AND
                    b.isActive = 1
            ";
            return builder($con,$sql);
            
        break;
    }

    mysqli_close($con);
?>