<?php
    if(!isset($_SESSION)) { session_start(); } 
    include 'appkey_generator.php';
    include dirname(__FILE__,2) . '/config.php';
    include $main_location . '/connection/conn.php';
    include '../builder/builder_select.php';
    include '../builder/builder_table.php';
    
    $created_by  = $_SESSION['id'];

    $sql = "
    
        SELECT
            a.itemCode,
            a.description,
            b.categoryName,
            FORMAT(a.cost,2) AS cost,
            IF(a.isActive = 1,'Active','Inactive') AS `status`,
            c.fullName,
            DATE_FORMAT(a.dateCreated,'%m/%d/%Y') AS dateCreated,
            a.id
        FROM
            dim_masterfile a
        INNER JOIN
            dim_category b
        ON
            a.categoryID = b.id
        INNER JOIN
            dim_user c
        ON
            a.createdBy = c.id
    
    ";
    return builder($con,$sql);
?>