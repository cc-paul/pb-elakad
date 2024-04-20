<?php
    if(!isset($_SESSION)) { session_start(); } 
    include 'appkey_generator.php';
    include dirname(__FILE__,2) . '/config.php';
    include $main_location . '/connection/conn.php';
    include '../builder/builder_select.php';
    include '../builder/builder_table.php';
    
    $dateFrom = $_POST["dateFrom"];
    $dateTo   = $_POST["dateTo"];    
    
    $sql = "
        SELECT
            CONCAT(c.fName,' ',c.lName) AS fullName,
            REPLACE(FORMAT(SUM(d.price),2),'.00','') AS price
        FROM
            mp_service_header a 
        INNER JOIN
            mp_service_details b
        ON 
            a.ref = b.ref
        INNER JOIN 
            mp_admin_therapist c 
        ON 
            a.therapistID = c.id
        INNER JOIN
            mp_admin_services d 
        ON 
            b.serviceID = d.id
        WHERE 
            a.`status` = 'Paid'
        AND
            DATE(a.datePaid) BETWEEN '".$dateFrom."' AND '".$dateTo."'
        GROUP BY
            a.therapistID
        ORDER BY
            CONCAT(c.fName,' ',c.lName) ASC
    ";
    return builder($con,$sql);
    
?>