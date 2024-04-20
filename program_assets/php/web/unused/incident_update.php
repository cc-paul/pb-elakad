<?php
    if(!isset($_SESSION)) { session_start(); } 
    include dirname(__FILE__,2) . '/config.php';
    include $main_location . '/connection/conn.php';
    include '../builder/builder_select.php';
    include '../builder/builder_table.php';
    
    $userid = $_SESSION['id'];
    $status = $_POST['status'];
    $rowid  = $_POST['rowid'];
    
    $query = "UPDATE scg_incident SET `status` = ?,dateUpdated = ?,updatedBy = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($con, $query)) {
        mysqli_stmt_bind_param($stmt,"ssss",$status,$global_date,$userid,$rowid);
        mysqli_stmt_execute($stmt);
        echo 1;
    } else {
        echo 0;
    }
    mysqli_close($con);

?>