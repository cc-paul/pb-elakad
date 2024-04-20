<?php
    if(!isset($_SESSION)) { session_start(); } 
    include 'appkey_generator.php';
    include dirname(__FILE__,2) . '/config.php';
    include $main_location . '/connection/conn.php';
    include '../builder/builder_select.php';
    include '../builder/builder_table.php';
    
    $response = array();
    $arrResult   = array();
    $error     = false;
    $message   = "no error";
    $quotationNumber = $_POST["quotationNumber"];
    
    $sql    = "
        SELECT
            a.quotationNumber,
            a.projectDescription,
            a.projectNumber,
            (SELECT REPLACE(FORMAT(SUM(total),2),'.00','') AS total FROM pims_project_item WHERE projectNumber = a.projectNumber AND isActive = 1) AS total,
            a.isItem,
            a.id
        FROM
            pims_project_header a WHERE a.isActive = 1 AND a.quotationNumber = '$quotationNumber'";
    $result = mysqli_query($con,$sql);
    
    while ($row  = mysqli_fetch_row($result)) {
        $temp = array();
        $temp["quotationNumber"] = $row[0];
        $temp["projectDescription"] = $row[1];
        $temp["total"] = $row[3];
        $temp["isItem"] = $row[4];
        $temp["id"] = $row[5];
        $temp["projectNumber"] = $row[2];
        $temp["items"] = getItems($row[2]);
        array_push($arrResult, $temp);
    }
    
    
    function getItems($projectNumber) {
        global $con;
        
        $items  = array();
        $output = array();
        
        $sql    = "
            SELECT
                IFNULL(b.suppliersName,'') AS suppliersName,
                IFNULL(c.itemCode,'') AS itemCode,
                IFNULL(c.itemName,'') AS itemName,
                FORMAT(a.qty,0) AS qty,
                IFNULL(d.uom,'Lot/s') AS uom,
                REPLACE(FORMAT(a.price,2),'.00','') AS price,
                REPLACE(FORMAT(a.total,2),'.00','') AS total,
                IF(a.itemID = 0,a.taskDescription,c.description) AS description
            FROM
                pims_project_item a
            LEFT JOIN
                pims_masterfile_supplier b
            ON
                a.supplierID = b.id
            LEFT JOIN
                pims_masterfile_items c
            ON
                a.itemID = c.id
            LEFT JOIN
                pims_masterfile_uom d
            ON
                c.uomID = d.id
            WHERE
                a.isActive = 1
            AND
                a.projectNumber = '$projectNumber'
        ";
        $result = mysqli_query($con,$sql);
        
        $items = array();
        while ($row  = mysqli_fetch_row($result)) {
            $temp = array();
            $temp["suppliersName"] = $row[2];
            $temp["itemCode"] = $row[1];
            $temp["description"] = $row[7];
            $temp["qty"] = $row[3];
            $temp["uom"] = $row[4];
            $temp["price"] = $row[5];
            $temp["total"] = $row[6];
            array_push($items, $temp);
        }
        
        return $items;
    }
    
    
    $response["error"]   = $error;
    $response["message"] = $message;
    $response["result"]  = $arrResult;
    //echo "<pre>" . json_encode($response,JSON_PRETTY_PRINT) . "</pre>";

    echo json_encode($response);
    mysqli_close($con);
?>