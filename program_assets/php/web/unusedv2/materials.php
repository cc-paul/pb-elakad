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
        case "display_projects" :
            
            $filter = $_POST["filter"];
            $query  = "";
            
            if ($filter == "") {
                $query = " AND IFNULL(a.`status`,'') IN ('WIP','On Hold','Completed') ";
            } else {
                $query = " AND IFNULL(a.`status`,'') = '$filter'";
            }
        
            
            $sql = "
                SELECT a.* FROM (
                SELECT
                    b.id,
                    a.id AS quotationID,
                    b.projectNumber,
                    a.quotationNumber,
                    b.poNumber,
                    a.quotationSubject,
                    c.clientsName,
                    DATE_FORMAT(b.startDate,'%m/%d/%Y') AS startDate,
                    DATE_FORMAT(b.endDate,'%m/%d/%Y') AS endDate,
                    b.`status`,
                    CONCAT(d.firstName,' ',d.lastName) AS fullName,
                    c.address,
                    c.contactNumber,
                    c.emailAddress,
                    c.contactPerson,
                    b.startDate AS unfStartDate,
                    b.endDate AS unfEndDate,
                    b.dateCreated,
                    b.reason,
                    (SELECT COUNT(*) FROM pims_project_item WHERE isActive = 1 AND itemID != 0 AND quotationNumber = a.quotationNumber) AS items
                FROM
                    pims_quotation a
                INNER JOIN
                    pims_project_approved b
                ON
                    a.quotationNumber = b.quotationNumber
                INNER JOIN
                    pims_masterfile_client c
                ON
                    a.clientID = c.id
                INNER JOIN
                    pims_user_registration d
                ON
                    a.engineerID = d.id
                WHERE
                    (a.createdBy = ".$_SESSION["id"]." 
                OR
                    a.engineerID = ".$_SESSION["id"].") 
                ) a  WHERE 1 $query ORDER BY a.dateCreated DESC;
            ";
            
            
            
            return builder($con,$sql);
            
        break;
    
        case "display_item" :
            
            $quotationNumber = $_POST["quotationNumber"];
            
            $sql = "
                SELECT
                    a.id,
                    b.itemCode,
                    b.description,
                    c.uom,
                    FORMAT(a.qty,0) AS qty,
                    FORMAT(IF(IFNULL(a.delivered,'') = '',0,a.delivered),0) AS delivered,
                    FORMAT(a.qty - IF(IFNULL(a.delivered,'') = '',0,a.delivered),0) AS descrepancies,
                    FORMAT(IF(IFNULL(a.installedOnSite,'') = '',0,a.installedOnSite),0) AS installedOnSite,
                    FORMAT(IF(IFNULL(a.delivered,'') = '',0,a.delivered) - (IF(IFNULL(a.installedOnSite,'') = '',0,a.installedOnSite)),0) AS updatedStock,
                    DATE_FORMAT(a.dateCreated,'%m/%d/%Y') AS dateCreated,
                    a.inventoryRemarks
                FROM
                    pims_project_item a
                INNER JOIN
                    pims_masterfile_items b
                ON
                    a.itemID = b.id
                INNER JOIN
                    pims_masterfile_uom c
                ON
                    b.uomID = c.id
                WHERE
                    a.isActive = 1 AND a.quotationNumber = '$quotationNumber'
                ORDER BY
                    b.itemCode ASC
            ";
            
            return builder($con,$sql);
            
        break;
    
        case "update_inventory" :
            
            $id = $_POST["id"];
            $delivered = $_POST["delivered"];
            $installed = $_POST["installed"];
            $remarks = $_POST["remarks"];
            
            $query = "UPDATE pims_project_item SET delivered = ?,installedOnSite = ?,inventoryRemarks = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"ssss",$delivered,$installed,$remarks,$id);
                mysqli_stmt_execute($stmt);
                
                $error   = false;
                $color   = "green";
                $message = "Changes has been applied";
            } else {
                $error   = true;
                $color   = "red";
                $message = "Error description: " . mysqli_error($con);
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