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
        case "add_quotation" :
            
            $quotationNumber = 'QTN-' . date('ymdHis', time());
            $clientID = $_POST["clientID"];
            $engineerID = $_POST["engineerID"];
            $quotationSubject = $_POST["quotationSubject"];
            $isNewQuotation = $_POST["isNewQuotation"];
            $id = $_POST["id"];
            
            if ($isNewQuotation == 1) {
                $query = "INSERT INTO pims_quotation (quotationNumber,clientID,engineerID,quotationSubject,dateCreated,createdBy,`status`) VALUES (?,?,?,?,?,?,'For Quotation')";
                if ($stmt = mysqli_prepare($con, $query)) {
                    mysqli_stmt_bind_param($stmt,"ssssss",$quotationNumber,$clientID,$engineerID,$quotationSubject,$global_date,$_SESSION["id"]);
                    mysqli_stmt_execute($stmt);
                    
                    $error   = false;
                    $color   = "green";
                    $message = "Quotation has been created";
                } else {
                    $error   = true;
                    $color   = "red";
                    $message = "Error description: " . mysqli_error($con);
                }
            } else {
                $query = "UPDATE pims_quotation SET clientID=?,engineerID=?,quotationSubject=?,`status`='For Quotation' WHERE id=?";
                if ($stmt = mysqli_prepare($con, $query)) {
                    mysqli_stmt_bind_param($stmt,"ssss",$clientID,$engineerID,$quotationSubject,$id);
                    mysqli_stmt_execute($stmt);
                    
                    $error   = false;
                    $color   = "green";
                    $message = "Quotation has been updated";
                } else {
                    $error   = true;
                    $color   = "red";
                    $message = "Error description: " . mysqli_error($con);
                }
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    
        case "display_quotation" :
            
            $filter = $_POST["filter"];
            $query  = "";
            
            if ($filter != "") {
                $query = " AND IFNULL(a.`status`,'') = '$filter' ";
            }
        
            
            $sql = "
                SELECT a.* FROM (
                SELECT
                    a.quotationNumber,
                    a.revisionNumber,
                    a.quotationSubject,
                    b.clientsName,
                    DATE_FORMAT(a.quotationDate,'%m/%d/%Y') AS quotationDate,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y %r') AS dateCreated,
                    CONCAT(c.firstName,' ',c.middleName,' ',c.lastName) AS inCharge,
                    b.address,
                    b.contactPerson,
                    b.contactNumber,
                    b.emailAddress,
                    a.id,
                    b.landLine,
                    a.quotationDate AS unfquotationDate,
                    a.engineerID,
                    a.createdBy,
                    a.clientID,
                    (SELECT IFNULL(COUNT(*),0) FROM pims_project_header WHERE quotationNumber = a.quotationNumber AND isActive = 1) AS totalItems,
                    IFNULL(a.`status`,'') AS `status`,
                    a.remarks
                FROM
                    pims_quotation a
                INNER JOIN
                    pims_masterfile_client b
                ON
                    a.clientID = b.id
                INNER JOIN
                    pims_user_registration c
                ON
                    a.engineerID = c.id
                WHERE
                    a.createdBy = ".$_SESSION["id"]." 
                OR
                    a.engineerID = ".$_SESSION["id"]." $query
                
                ) a WHERE 1 $query ORDER BY
                    a.id DESC
            ";
            
            return builder($con,$sql);
            
        break;
    
        case "update_quotation_date" :
            
            $id = $_POST["id"];
            $quotationDate = $_POST["quotationDate"];
            
            $query = "UPDATE pims_quotation SET quotationDate = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"ss",$quotationDate,$id);
                mysqli_stmt_execute($stmt);
                
                $error   = false;
                $color   = "green";
                $message = "Quotation has been updated";
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
    
        case "select_supplier" :
            
            $itemID = $_POST["itemID"];
            
            $sql    = "
                SELECT
                    c.id,
                    CONCAT(c.suppliersName,' - ','Price : ',REPLACE(FORMAT(b.price,2),'.00','')) AS supplier
                FROM
                    pims_masterfile_items a
                INNER JOIN
                    pims_masterfile_item_supplier b
                ON
                    a.id = b.itemID
                INNER JOIN
                    pims_masterfile_supplier c
                ON
                    b.supplierID = c.id
                WHERE
                    b.isActive = 1
                AND
                    a.id = $itemID
            ";
     
            $result = mysqli_query($con,$sql);
            
            $json = array();
            while ($row  = mysqli_fetch_row($result)) {
                $json[] = array(
                    'id'       => $row[0],
                    'suppliersName' => $row[1]
                );
            }
            echo json_encode($json);
            
        break;
    
        case "add_project" :
        case "add_project_nt" :
            
            $isNewTask = $_POST["isNewTask"];
            $projectNumber = $_POST["projectNumber"];
            $queryItems = $_POST["queryItems"];
            $taskDescription = $_POST["taskDescription"];
            $createdBy = $_SESSION["id"];
            $quotationNumber = $_POST["quotationNumber"];
            $isItem = $_POST["isItem"];
            $taskID = $_POST["taskID"];
            $query = "";
            
            if ($isNewTask == 1) {
                $query = "INSERT INTO pims_project_header (projectNumber,projectDescription,dateCreated,createdBy,quotationNumber,isItem) VALUES ('$projectNumber','$taskDescription','$global_date','$createdBy','$quotationNumber','$isItem')";
            } else {
                $query = "UPDATE pims_project_header SET projectDescription = '$taskDescription' WHERE id = '$taskID'";
            }
            
        
            if (mysqli_query($con, $query)) {
                
                $queryItems = str_replace('dateCreated',$global_date,$queryItems);
                $queryItems = str_replace('createdBy',$createdBy,$queryItems);
                
                if ($isNewTask == 0) {
                    mysqli_query($con,"UPDATE pims_project_item SET isActive = 0 WHERE projectNumber = '$projectNumber'");
                }
                
                
                if (mysqli_query($con,"INSERT INTO pims_project_item (projectNumber,quotationNumber,supplierID,itemID,qty,price,total,createdBy,dateCreated,taskDescription) VALUES " . $queryItems)) {
                    $error   = false;
                    $color   = "green";
                    $message = "Project has been added successfully";
                } else {
                    $error   = true;
                    $color   = "red";
                    $message = "Error description: " . mysqli_error($con);
                }
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
    
        case 'get_task_item' :
            
            $projectNumber = $_POST["projectNumnber"];
            
            $sql    = "
                SELECT
                    a.supplierID,
                    b.suppliersName AS supplier,
                    a.itemID,
                    c.itemName,
                    a.qty,
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
                WHERE
                    a.projectNumber = '$projectNumber'
                AND
                    a.isActive = 1
            ";
            
            $result = mysqli_query($con,$sql);
            
            $json = array();
            while ($row  = mysqli_fetch_row($result)) {
                $json[] = array(
                    'supplierID'  => $row[3],
                    'supplier'  => $row[1],
                    'itemID'  => $row[2],
                    'itemName'  => $row[7],
                    'qty'  => $row[4],
                    'price'  => $row[5],
                    'total'  => $row[6]
                );
            }
            echo json_encode($json);
            
        break;
    
        case "delete_task" :
            
            $id = $_POST["id"];
            mysqli_query($con,"UPDATE pims_project_header SET isActive = 0 WHERE id = '$id'");
            
        break;
    
        case "send_for_approval" :
            
            $quotationNumber = $_POST["quotationNumber"];
            $filter = $_POST["filter"];
            $remarks = $_POST["remarks"];
            
            mysqli_query($con,"UPDATE pims_quotation SET revisionNumber = revisionNumber + 1 WHERE quotationNumber = '$quotationNumber' AND `status` = 'Revise'");
            
            if (mysqli_query($con,"UPDATE pims_quotation SET `status` = '$filter',remarks = '$remarks' WHERE quotationNumber = '$quotationNumber'")) {
                $error   = false;
                $color   = "green";
                $message = "";
                
                switch ($filter) {
                    case "Requires Approval" :
                        $message = "Quotation has been sent. Please wait for the approval";
                    break;
                    case "Approved" :
                        $projectNumber = 'PRN-' . date('ymdHis', time());
                        
                        mysqli_query($con,"INSERT INTO pims_project_approved (projectNumber,quotationNumber,`status`,dateCreated) VALUES ('$projectNumber','$quotationNumber','Approved','$global_date')");
                        
                        $message = "Quotation has been approved";
                    break;
                    case "Revise" :
                        $message = "Quotation has been revise";
                    break;
                    case "Cancelled" :
                        $message = "Quotation has been cancelled";
                    break;
                }
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