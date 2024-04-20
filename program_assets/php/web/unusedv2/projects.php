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
                    a.createdBy
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
    
        case "update_dates" :
            
            $startDate = $_POST["startDate"];
            $endDate = $_POST["endDate"];
            $poNumber = $_POST["poNumber"];
            $id = $_POST["id"];
            
            
            $query = "UPDATE pims_project_approved SET startDate=?,endDate=?,poNumber=? WHERE id=?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"ssss",$startDate,$endDate,$poNumber,$id);
                mysqli_stmt_execute($stmt);
                
                mysqli_query($con,"UPDATE pims_project_approved SET `status` = 'New' WHERE `status` = 'Approved' AND id =".$id);
                
                
                $message = "Project has been updated successfully";
            } else {
                $error = true;
                $color = "red";
                $message = "Error description: " . mysqli_error($con);
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    
        case "update_remarks" :
            
            $id = $_POST["id"];
            $status = $_POST["status"];
            $reason = $_POST["reason"];
            
            $query = "UPDATE pims_project_approved SET `status`=?,reason=? WHERE id=?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"sss",$status,$reason,$id);
                mysqli_stmt_execute($stmt);
                
                $message = "Project has been updated successfully";
            } else {
                $error = true;
                $color = "red";
                $messge = "Error updating project";
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