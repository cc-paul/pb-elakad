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
        case "save_reason" :
            
            $visitorsID      = $_POST["visitorsID"];
            $fullName        = $_POST["fullName"];
            $mobileNumber    = $_POST["mobileNumber"];
            $completeAddress = $_POST["completeAddress"];
            $reason          = $_POST["reason"];
            
            $query = "UPDATE el_map_activity SET isActive = 0 WHERE visitorsID = ?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$visitorsID);
                mysqli_stmt_execute($stmt);
                
                $query = "
                    INSERT INTO el_map_activity (
                        visitorsID,
                        fullName,
                        mobileNumber,
                        completeAddress,
                        reason
                    ) VALUES (
                        ?,?,?,?,?
                    )
                ";
                if ($stmt = mysqli_prepare($con, $query)) {
                    mysqli_stmt_bind_param($stmt,"sssss",$visitorsID,$fullName,$mobileNumber,$completeAddress,$reason);
                    mysqli_stmt_execute($stmt);
                    
                    $_SESSION['visitorsID'] = $visitorsID;
                    
                    $error   = false;
                    $color   = "green";
                    $message = "";
                } else {
                    $error   = true;
                    $color   = "red";
                    $message = "Error saving location" . mysqli_error($con);
                }


            } else {
                $error   = true;
                $color   = "red";
                $message = "Error deleting old location" . mysqli_error($con);
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