<?php
    if(!isset($_SESSION)) { session_start(); } 
    include 'appkey_generator.php';
    include dirname(__FILE__,2) . '/config.php';
    include $main_location . '/connection/conn.php';
    include '../builder/builder_select.php';
    include '../builder/builder_table.php';
    
    $id           = $_POST["id"];
    $status       = $_POST["status"];
    $driver       = $_POST["driver"];
    $rejectReason = $_POST["rejectReason"];
    
    $error   = false;
    $message = "Reservation has been updated successfully";
    $json    = array();
    
    $query = "UPDATE mp_service_header SET `status`=?, dateUpdated=?, rejectReason=?, driverID=? WHERE id=?";
    if ($stmt = mysqli_prepare($con, $query)) {
        mysqli_stmt_bind_param($stmt,"sssss",$status,$global_date,$rejectReason,$driver,$id);
        mysqli_stmt_execute($stmt);
        
        if ($status == "Accepted") {
            $query = "
                INSERT INTO mp_admin_message (
                    mobile,
                    message
                )
                
                SELECT
                    b.mobile collate utf8mb4_unicode_ci AS mobile,
                    CONCAT('Hello Mr/Mrs ',b.lastName,', were here to inform you that your service request has been approved. Click the mapalad app to view the details') collate utf8mb4_unicode_ci AS message
                FROM
                    mp_service_header a
                INNER JOIN
                    mp_customer_registration b
                ON
                    a.createdBy = b.id
                WHERE
                    a.id = ?
                    
                UNION ALL
                
                SELECT
                    b.mobileNumber collate utf8mb4_unicode_ci AS mobile,
                    CONCAT('Hello Mr/Mrs ',b.lName,', were here to inform you that your have a scheduled service. Kindly coordinate to your admin to check the details') collate utf8mb4_unicode_ci AS message
                FROM
                    mp_service_header a
                INNER JOIN
                    mp_admin_therapist b
                ON
                    a.therapistID = b.id
                WHERE
                    a.id = ?
                    
                UNION ALL
                
                SELECT
                    b.mobileNumber collate utf8mb4_unicode_ci AS mobile,
                    CONCAT('Hello Mr/Mrs ',b.lName,', were here to inform you that your have a scheduled service. Kindly coordinate to your admin to check the details') collate utf8mb4_unicode_ci AS message
                FROM
                    mp_service_header a
                INNER JOIN
                    mp_admin_therapist b
                ON
                    a.driverID = b.id
                WHERE
                    a.id = ?
            ";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"sss",$id,$id,$id);
                mysqli_stmt_execute($stmt);
            }
        } else {
            $query = "
                INSERT INTO mp_admin_message (
                    mobile,
                    message
                )
                
                SELECT
                    b.mobile collate utf8mb4_unicode_ci AS mobile,
                    CONCAT('Hello Mr/Mrs ',b.lastName,', were here to inform you that your service request has been declined. Click the mapalad app to view the details') collate utf8mb4_unicode_ci AS message
                FROM
                    mp_service_header a
                INNER JOIN
                    mp_customer_registration b
                ON
                    a.createdBy = b.id
                WHERE
                    a.id = ?
            ";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$id);
                mysqli_stmt_execute($stmt);
            }
        }
    } else {
        $error   = true;
        $message = "Oooops something went wrong.";
    }
    
    $json[] = array(
        'error' => $error,
        'message' => $message
    );
    
    echo json_encode($json);
    mysqli_close($con);
?>