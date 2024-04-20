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
        case "display_service" :
            
            $sql = "
                SELECT
                    a.service,
                    IF(a.isActive = 1,'Active','Disabled') AS status,
                    DATE_FORMAT(a.dateCreated,'%m/%d/%Y') AS dateCreated,
                    IF(a.isActive = 1,true,false) AS isActive,
                    a.id
                FROM
                    es_service a
                ORDER BY
                    a.dateCreated DESC;
            ";
            return builder($con,$sql);
            
        break;
    
        case "save_service" :
        
            $serviceID      = $_POST["serviceID"];
            $isNewService   = $_POST["isNewService"];
            $service        = $_POST["service"];
            $oldServiceName = $_POST["oldServiceName"];
            $isActive        = $_POST["isActive"];
            $arr_exist       = array();
            
            if ($isNewService == 1) {
                $find_service = mysqli_query($con,"SELECT * FROM es_service WHERE service = '$service'");
                if (mysqli_num_rows($find_service) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Service");
                }
                
                if (count($arr_exist) == 0) {
                    $query = "INSERT INTO es_service (service,isActive,dateCreated)
                    VALUES (?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sss",$service,$isActive,$global_date);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Service has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving service" . mysqli_error($con);
                    }
                } else {
                    $error   = true;
                    $color   = "orange";
                    $message = "Service already exist";
                }
            } else {
                if (strtolower($service) != strtolower($oldServiceName)) {
                    $find_service = mysqli_query($con,"SELECT * FROM es_service WHERE service = '$service'");
                    if (mysqli_num_rows($find_service) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Service");
                    }
                }
                
                if (count($arr_exist) == 0) {
                    $query = "UPDATE es_service SET service=?,isActive=? WHERE id=?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sss",$service,$isActive,$serviceID);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Service has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving service" . mysqli_error($con);
                    }
                } else {
                    $error   = true;
                    $color   = "orange";
                    $message = "Service already exist";
                }
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    }
    
    mysqli_close($con);
?>