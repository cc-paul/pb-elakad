<?php
    if(!isset($_SESSION)) { session_start(); } 
    include 'appkey_generator.php';
    include dirname(__FILE__,2) . '/config.php';
    include $main_location . '/connection/conn.php';
    include '../builder/builder_select.php';
    include '../builder/builder_table.php';
    
    $ref = $_POST["ref"];
    //$dateTo   = $_POST["dateTo"];    
    
    $sql = "
        SELECT
            c.category,
            a.service,
            REPLACE(FORMAT(a.price,2),'.00','') AS price
        FROM
            mp_admin_services a
        INNER JOIN
            mp_service_details b
        ON 
            b.serviceID = a.id
        INNER JOIN
            mp_admin_category c
        ON
            a.category_id = c.id
        WHERE
            b.ref = '$ref'
        ORDER BY
            c.category ASC,
            a.service ASC
    ";
    return builder($con,$sql);
    
?>