<?php
    if(!isset($_SESSION)) { session_start(); } 
    include 'appkey_generator.php';
    include dirname(__FILE__,2) . '/config.php';
    include $main_location . '/connection/conn.php';
    include '../builder/builder_select.php';
    include '../builder/builder_table.php';
    
    //$dateFrom = $_POST["dateFrom"];
    //$dateTo   = $_POST["dateTo"];    
    
    $sql = "
        SELECT
            CONCAT(b.firstName,' ',b.lastName) AS fullName,
            DATE_FORMAT(a.dateCreated,'%M %d %Y, %r') AS dateCreated,
            a.feedBack
        FROM
            mp_admin_feedback a
        INNER JOIN
            mp_customer_registration b
        ON
            a.customerID = b.id
        ORDER BY
            a.dateCreated DESC;
    ";
    return builder($con,$sql);
    
?>