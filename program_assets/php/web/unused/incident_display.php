<?php
    if(!isset($_SESSION)) { session_start(); } 
    include dirname(__FILE__,2) . '/config.php';
    include $main_location . '/connection/conn.php';
    include '../builder/builder_select.php';
    include '../builder/builder_table.php';
        
    $sql = "
        SELECT
            a.id,
            lpad( a.id, 4, '0' ) AS rid,
            a.address,
            a.`status`,
            a.description,
            a.lat,
            a.`long`,
            DATE_FORMAT(a.dateCreated,'%M %d %Y, %h:%i %r') AS dateCreated,
            DATE_FORMAT(a.photo_DateTaken,'%M %d %Y, %h:%i %r') AS photoDate,
            a.link,
            CONCAT(b.firstName,' ',b.lastName) AS reportedBy,
            b.email,
            b.mobileNumber
        FROM
            scg_incident a
        INNER JOIN
            scg_registration b
        ON
            a.createdBy = b.id
        WHERE
            a.isDeleted = 0
        ORDER BY
            a.dateCreated DESC
    ";
    return builder($con,$sql);
?>