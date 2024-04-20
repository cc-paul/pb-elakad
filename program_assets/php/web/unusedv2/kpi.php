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
            
            if ($filter != "") {
                $query = " AND IFNULL(a.`status`,'') = '$filter' ";
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
                    DATE_FORMAT( b.startDate, '%m/%d/%Y' ) AS startDate,
                    DATE_FORMAT( b.endDate, '%m/%d/%Y' ) AS endDate,
                    b.`status`,
                    CONCAT( d.firstName, ' ', d.lastName ) AS fullName,
                    c.address,
                    c.contactNumber,
                    c.emailAddress,
                    c.contactPerson,
                    c.landLine,
                    b.startDate AS unfStartDate,
                    b.endDate AS unfEndDate,
                    b.dateCreated,
                    b.reason,
                    IFNULL((
                        SELECT
                                FORMAT(SUM(x.qty),0)
                        FROM
                                pims_project_item x
                        INNER JOIN
                                pims_masterfile_items y
                        ON
                                x.itemID = y.id
                        INNER JOIN
                                pims_masterfile_uom z
                        ON
                                y.uomID = z.id
                        WHERE
                                x.isActive = 1 AND x.quotationNumber = a.quotationNumber
                    ),2) AS totalQty,
                    IFNULL((
                        SELECT
                                FORMAT(SUM(IF(IFNULL(x.delivered,'') = '',0,x.delivered)),0)
                        FROM
                                pims_project_item x
                        INNER JOIN
                                pims_masterfile_items y
                        ON
                                x.itemID = y.id
                        INNER JOIN
                                pims_masterfile_uom z
                        ON
                                y.uomID = z.id
                        WHERE
                                x.isActive = 1 AND x.quotationNumber = a.quotationNumber
                    ),2) AS totalDelivered,
                    IFNULL((
                        SELECT
                                FORMAT(SUM(x.qty - IF(IFNULL(x.delivered,'') = '',0,x.delivered)),0)
                        FROM
                                pims_project_item x
                        INNER JOIN
                                pims_masterfile_items y
                        ON
                                x.itemID = y.id
                        INNER JOIN
                                pims_masterfile_uom z
                        ON
                                y.uomID = z.id
                        WHERE
                                x.isActive = 1 AND x.quotationNumber = a.quotationNumber
                    ),2) AS totalDescrepancies,
                    IFNULL((
                        SELECT
                                FORMAT(SUM(IF(IFNULL(x.installedOnSite,'') = '',0,x.installedOnSite)),0)
                        FROM
                                pims_project_item x
                        INNER JOIN
                                pims_masterfile_items y
                        ON
                                x.itemID = y.id
                        INNER JOIN
                                pims_masterfile_uom z
                        ON
                                y.uomID = z.id
                        WHERE
                                x.isActive = 1 AND x.quotationNumber = a.quotationNumber
                    ),2) AS totalInstalled,
                    IFNULL((
                        SELECT
                                FORMAT(SUM(IF(IFNULL(x.delivered,'') = '',0,x.delivered) - (IF(IFNULL(x.installedOnSite,'') = '',0,x.installedOnSite))),0)
                        FROM
                                pims_project_item x
                        INNER JOIN
                                pims_masterfile_items y
                        ON
                                x.itemID = y.id
                        INNER JOIN
                                pims_masterfile_uom z
                        ON
                                y.uomID = z.id
                        WHERE
                                x.isActive = 1 AND x.quotationNumber = a.quotationNumber
                    ),2) AS totalUpdatedStocks,
		(SELECT REPLACE(FORMAT(SUM(total),2),'.00','') AS total FROM pims_project_item WHERE quotationNumber = a.quotationNumber AND isActive = 1) AS total
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
                ) a  WHERE 1 $query AND IFNULL(a.unfStartDate,'') != '' AND IFNULL(a.unfEndDate,'') != '' ORDER BY a.dateCreated DESC;
            ";
            
            
           
            return builder($con,$sql);
            
        break;
    }

    mysqli_close($con);    
?>