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
            a.id,
            a.ref,
            proper(IF(a.isHomeService = 1,'Home Service',b.branchName)) AS branchName,
            proper(CONCAT(c.fName,' ',c.lName)) AS therapistName,
            DATE_FORMAT(a.dateScheduled,'%M %d %Y') AS dateScheduled,
            CONCAT(DATE_FORMAT(e.timeFrom,'%h:%i %p'),' to ',DATE_FORMAT(e.timeTo,'%h:%i %p'))  AS timeScheduled,
            a.remarks,
            a.status,
            (
                SELECT
                    REPLACE(FORMAT(SUM(y.price),2),'.00','') AS price 
                FROM
                    mp_service_details x
                INNER JOIN
                    mp_admin_services y
                ON
                    x.serviceID = y.id
                WHERE
                    x.ref = a.ref
            ) AS price,
            a.createdBy,
            CONCAT(d.firstName,' ',d.lastName) AS customer,
            a.therapistID,
            a.rejectReason,
            d.mobile AS mobileNumber,
            a.isHomeService,
            a.driverID,
            a.rejectReason
        FROM
            mp_service_header a
        LEFT JOIN
            mp_admin_branch b
        ON
            a.branchID = b.id
        INNER JOIN
            mp_admin_therapist c
        ON
            a.therapistID = c.id
        INNER JOIN
            mp_customer_registration d
        ON
            a.createdBy = d.id
        INNER JOIN
			mp_admin_schedules e
		ON 
			a.scheduleID = e.id
        WHERE 
            a.isActive = 1
        ORDER BY
            a.dateScheduled DESC,
            a.`status` ASC
    ";
    return builder($con,$sql);
    
?>