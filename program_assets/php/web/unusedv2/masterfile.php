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
        case "new_user" :
            
            $isNewUser       = $_POST["isNewUser"];
            $userID          = $_POST["userID"];
            $oldEmpID        = $_POST["oldEmpID"];
            $oldUsername     = $_POST["oldUsername"];
            $oldEmailAddress = $_POST["oldEmailAddress"];
            $empID           = $_POST["empID"];
            $positionID      = $_POST["positionID"];
            $firstName       = $_POST["firstName"];
            $middleName      = $_POST["middleName"];
            $lastName        = $_POST["lastName"];
            $emailAddress    = $_POST["emailAddress"];
            $username        = $_POST["username"];
            $mobileNumber    = $_POST["mobileNumber"];
            $isActive        = $_POST["isActive"];
            
            $isAssigned         = $_POST["isAssigned"];
            $bday               = $_POST["bday"];
            $gender             = $_POST["gender"];
            $joinDate           = $_POST["joinDate"];
            $sourceHire         = $_POST["sourceHire"];
            $totalYears         = $_POST["totalYears"];
            $totalMonths        = $_POST["totalMonths"];
            $empType            = $_POST["empType"];
            $contactName        = $_POST["contactName"];
            $relationship       = $_POST["relationship"];
            $relationshipNumber = $_POST["relationshipNumber"];
            $tin                = $_POST["tin"];
            $sss                = $_POST["sss"];
            $pid                = $_POST["pid"];
            $pagibigID          = $_POST["pagibigID"];
            
            
            $arr_exist       = array();
            
            if ($isNewUser == 1) {
                $find_email = mysqli_query($con,"SELECT * FROM hris_user_registration WHERE emailAddress = '$emailAddress'");
                if (mysqli_num_rows($find_email) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Email");
                }
                
                $find_user = mysqli_query($con,"SELECT * FROM hris_user_registration WHERE username = '$username'");
                if (mysqli_num_rows($find_user) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Username");
                }
                
                
                $find_empid = mysqli_query($con,"SELECT * FROM hris_user_registration WHERE userID = '$empID'");
                if (mysqli_num_rows($find_empid) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Employee ID");
                }
                
                if (count($arr_exist) != 0) {
                    $error   = true;
                    $color   = "orange";
                    $message = "";
                    
                    if (count($arr_exist) != 3) {
                        $message = implode(" and ",$arr_exist) . " already exist";
                    } else {
                        $message = $arr_exist[0] . "," . $arr_exist[1] . " and " . $arr_exist[2] . " " . " already exist";
                    }
                } else {
                    $query = "INSERT INTO hris_user_registration (userID,username,`password`,positionID,lastName,middleName,firstName,mobileNumber,emailAddress,dateCreated,isActive,isAssigned,bday,gender,joinDate,sourceHire,totalYears,totalMonths,empType,contactName,relationship,relationshipNumber,tin,sss,pid,pagibigID) VALUES (?,?,MD5(?),?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssssssssssssssssssssssssss",$empID,$username,$username,$positionID,$lastName,$middleName,$firstName,$mobileNumber,$emailAddress,$global_date,$isActive,$isAssigned,$bday,$gender,$joinDate,$sourceHire,$totalYears,$totalMonths,$empType,$contactName,$relationship,$relationshipNumber,$tin,$sss,$pid,$pagibigID);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Account has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving account";
                    }
                }
            } else {
                if ($oldEmailAddress != $emailAddress) {
                    $find_email = mysqli_query($con,"SELECT * FROM hris_user_registration WHERE emailAddress = '$emailAddress'");
                    if (mysqli_num_rows($find_email) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Email");
                    }
                }
                
                if ($oldUsername != $username) {
                    $find_user = mysqli_query($con,"SELECT * FROM hris_user_registration WHERE username = '$username'");
                    if (mysqli_num_rows($find_user) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Username");
                    }
                }
                
                if ($oldEmpID != $empID) {
                    $find_empid = mysqli_query($con,"SELECT * FROM hris_user_registration WHERE userID = '$empID'");
                    if (mysqli_num_rows($find_empid) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Employee ID");
                    }
                }
                
                if (count($arr_exist) != 0) {
                    $error   = true;
                    $color   = "orange";
                    $message = "";
                    
                    if (count($arr_exist) != 3) {
                        $message = implode(" and ",$arr_exist) . " already exist";
                    } else {
                        $message = $arr_exist[0] . "," . $arr_exist[1] . " and " . $arr_exist[2] . " " . " already exist";
                    }
                } else {
                    $query = "UPDATE hris_user_registration SET userID=?,username=?,positionID=?,lastName=?,middleName=?,firstName=?,mobileNumber=?,emailAddress=?,isActive=?,isAssigned=?,bday=?,gender=?,joinDate=?,sourceHire=?,totalYears=?,totalMonths=?,empType=?,contactName=?,relationship=?,relationshipNumber=?,tin=?,sss=?,pid=?,pagibigID=? WHERE id=?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sssssssssssssssssssssssss",$empID,$username,$positionID,$lastName,$middleName,$firstName,$mobileNumber,$emailAddress,$isActive,$isAssigned,$bday,$gender,$joinDate,$sourceHire,$totalYears,$totalMonths,$empType,$contactName,$relationship,$relationshipNumber,$tin,$sss,$pid,$pagibigID,$userID);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Account has been updated successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error updating account";
                    }
                }
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    
        case "reset_password" :
            
            $userID = $_POST["userID"];
            
            $query = "UPDATE hris_user_registration SET `password` = MD5(username),isPasswordChange = 0 WHERE id = ?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$userID);
                mysqli_stmt_execute($stmt);
                
                $error   = false;
                $color   = "green";
                $message = "Password has been reset. Please inform the user that his current password is also same as his username"; 
            } else {
                $error   = true;
                $color   = "red";
                $message = "Error reseting password";
            }

            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
        
        case "display_user" :
            
            $sql = "
                SELECT
                    a.userID,
                    a.username,
                    a.firstName,
                    a.middleName,
                    a.lastName,
                    a.mobileNumber,
                    a.emailAddress,
                    b.position,
                    IF(a.isActive = 1,'Active','Disabled') AS status,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y %r') AS dateCreated,
                    IF(a.isActive = 1,true,false) AS isActive,
                    a.id,
                    a.positionID,
                    a.isAssigned,
                    a.bday,
                    a.gender,
                    a.joinDate,
                    a.sourceHire,
                    a.totalYears,
                    a.totalMonths,
                    a.empType,
                    a.contactName,
                    a.relationship,
                    a.relationshipNumber,
                    a.tin,
                    a.sss,
                    a.pid,
                    a.pagibigID
                FROM
                   hris_user_registration a
                INNER JOIN
                   hris_user_position b 
                ON
                    a.positionID = b.id
                ORDER BY
                    a.userID
            ";
            return builder($con,$sql);
            
        break;
    
        case "select_position" :
            
            $sql    = "
                SELECT
                    a.id,
                    a.position
                FROM
                   hris_user_position a
                WHERE
                    a.isActive = 1
                ORDER BY
                    a.position ASC;
            ";
            $result = mysqli_query($con,$sql);
            
            $json = array();
            while ($row  = mysqli_fetch_row($result)) {
                $json[] = array(
                    'id'       => $row[0],
                    'position' => $row[1]
                );
            }
            echo json_encode($json);
            
        break;
    
        case "display_client" :
            
            $sql = "
                SELECT
                    a.clientsName,
                    a.address,
                    a.contactNumber,
                    a.contactPerson,
                    a.emailAddress,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y %r') AS dateCreated,
                    IF(a.isActive = 1,'Active','Disabled') AS `status`,
                    a.id,
                    a.isActive,
                    a.landLine
                FROM
                   hris_masterfile_client a
                ORDER BY
                    a.clientsName ASC
            ";
            return builder($con,$sql);
            
        break;
    
        case "new_client" :
            
            $oldClientsName = $_POST["oldClientsName"];
            $oldClientsID = $_POST["oldClientsID"];
            $isNewClient = $_POST["isNewClient"];
            $clientsName = $_POST["clientsName"];
            $clientsAddress = $_POST["clientsAddress"];
            $contactNumber = $_POST["contactNumber"];
            $contactPerson = $_POST["contactPerson"];
            $emailAddress = $_POST["emailAddress"];
            $landline = $_POST["landline"];
            $isActive = $_POST["isActive"];
            $arr_exist = array();
            
            
            if ($isNewClient == 1) {
                $find_client = mysqli_query($con,"SELECT * FROM hris_masterfile_client WHERE clientsName = '$clientsName'");
                if (mysqli_num_rows($find_client) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Client");
                }
                
                if (count($arr_exist) != 0) {
                    $error   = true;
                    $color   = "orange";
                    $message = "Client already exist";
                } else {
                    $query = "INSERT INTO hris_masterfile_client (clientsName,address,contactNumber,contactPerson,emailAddress,isActive,dateCreated,landLine) VALUES (?,?,?,?,?,?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssssssss",$clientsName,$clientsAddress,$contactNumber,$contactPerson,$emailAddress,$isActive,$global_date,$landline);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Client has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving Client";
                    }
                }
            } else {
                if ($clientsName != $oldClientsName) {
                    $find_client = mysqli_query($con,"SELECT * FROM hris_masterfile_client WHERE clientsName = '$clientsName'");
                    if (mysqli_num_rows($find_client) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Client");
                    }
                }
                
                if (count($arr_exist) != 0) {
                    $error   = true;
                    $color   = "orange";
                    $message = "Client already exist";
                } else {
                    $query = "UPDATE hris_masterfile_client SET clientsName=?,address=?,contactNumber=?,contactPerson=?,emailAddress=?,isActive=?,landLine=? WHERE id=?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssssssss",$clientsName,$clientsAddress,$contactNumber,$contactPerson,$emailAddress,$isActive,$landline,$oldClientsID);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Client has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving Client";
                    }
                }
            }
            
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
        break;
    
        case "display_client_branch" :
            
            $clientID = $_POST["clientID"];
            
            
            $sql = "
                SELECT
                    a.id,
                    a.branchName,
                    a.address,
                    a.coordinates,
                    DATE_FORMAT(a.dateCreated,'%m/%d/%Y') AS dateCreated
                FROM
                    hris_mastefile_client_branches a
                WHERE
                    a.isActive = 1
                AND
                    a.clientID = $clientID
                ORDER BY
                    a.branchName ASC
            ";
            
            return builder($con,$sql);
            
        break;
    
        case "save_client_branch" :
        
            $clientID = $_POST["clientID"];
            $branchName =  $_POST["branchName"];
            $address =   $_POST["address"];
            $coordinates =  $_POST["coordinates"];
            $oldBranchName =  $_POST["oldBranchName"];
            $currentBranchID =  $_POST["currentBranchID"];
            $isNewBranch =  $_POST["isNewBranch"];
            
            if ($isNewBranch == 1) {
                $find_query = mysqli_query($con,"SELECT * FROM hris_mastefile_client_branches WHERE branchName = '$branchName' AND clientID = $clientID AND isActive = 1");
                if (mysqli_num_rows($find_query) == 0) {
                    mysqli_next_result($con);
                    
                    $query = "INSERT INTO hris_mastefile_client_branches (branchName,address,coordinates,dateCreated,clientID) VALUES (?,?,?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sssss",$branchName,$address,$coordinates,$global_date,$clientID);
                        mysqli_stmt_execute($stmt);
                       
                        $error   = false;
                        $color   = "green";
                        $message = "Branch has been added"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving branch"; 
                    }

                } else {
                    $error   = true;
                    $color   = "red";
                    $message = "Branch already exist"; 
                }
            } else {
                $isExist = 1;
                
                if ($branchName != $oldBranchName) {
                    $find_query = mysqli_query($con,"SELECT * FROM hris_mastefile_client_branches WHERE branchName = '$branchName' AND clientID = $clientID AND isActive = 1");
                    if (mysqli_num_rows($find_query) == 0) {
                        mysqli_next_result($con);
                        
                        $isExist = 0;
    
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Branch already exist"; 
                    }
                }
                
                if ($isExist == 0) {
                    $query = "UPDATE hris_mastefile_client_branches SET branchName=?,address=?,coordinates=?,clientID=? WHERE id = ?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sssss",$branchName,$address,$coordinates,$clientID,$currentBranchID);
                        mysqli_stmt_execute($stmt);
                       
                        $error   = false;
                        $color   = "green";
                        $message = "Branch has been added"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving branch"; 
                    }
                }
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    
        case "delete_branch" :
            
            $currentBranchID =  $_POST["currentBranchID"];
            
            $query = "UPDATE hris_mastefile_client_branches SET isActive = 0 WHERE id = ?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$currentBranchID);
                mysqli_stmt_execute($stmt);
               
                $error   = false;
                $color   = "green";
                $message = "Branch has been deleted"; 
            } else {
                $error   = true;
                $color   = "red";
                $message = "Error deleting branch"; 
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    
        case "add_pic_client" :
            
            $clientID  = $_POST["clientID"];
            $userID    = $_POST["userID"];
            
            $find_query = mysqli_query($con,"SELECT * FROM hris_client_assigned WHERE clientID = $clientID AND userID = $userID AND isActive = 1");
            if (mysqli_num_rows($find_query) == 0) {
                mysqli_next_result($con);
                
                $query = "INSERT INTO hris_client_assigned (clientID,userID) VALUES (?,?)";
                if ($stmt = mysqli_prepare($con, $query)) {
                    mysqli_stmt_bind_param($stmt,"ss",$clientID,$userID);
                    mysqli_stmt_execute($stmt);
                   
                    $error   = false;
                    $color   = "green";
                    $message = "Client has been added"; 
                } else {
                    $error   = true;
                    $color   = "red";
                    $message = "Error adding Client"; 
                }

            } else {
                $error   = true;
                $color   = "red";
                $message = "Client already added"; 
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
         break;
        
        case "display_pic_client" :
            
            $userID  = $_POST["userID"];
        
            $sql = "
                SELECT
                    b.clientsName,
                    b.address,
                    a.id
                FROM
                    hris_client_assigned a
                INNER JOIN
                    hris_masterfile_client b
                ON
                    a.clientID = b.id
                WHERE
                    a.isActive = 1
                AND
                    a.userID = $userID
                ORDER BY
                    b.clientsName ASC
            ";
            return builder($con,$sql);
        
        break;
    
        case "delete_pic_client" :
            
            $clientID  = $_POST["clientID"];
            
            $query = "UPDATE hris_client_assigned SET isActive = 0 WHERE id = ?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$clientID);
                mysqli_stmt_execute($stmt);
               
                $error   = false;
                $color   = "green";
                $message = "Branch has been deleted"; 
            } else {
                $error   = true;
                $color   = "red";
                $message = "Error deleting branch"; 
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    
        case "display_user_assignment" :
            
            $sql = "
                SELECT
                    a.userID,
                    a.username,
                    a.firstName,
                    a.middleName,
                    a.lastName,
                    a.mobileNumber,
                    a.emailAddress,
                    b.position,
                    IF(a.isActive = 1,'Active','Disabled') AS status,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y %r') AS dateCreated,
                    IF(a.isActive = 1,true,false) AS isActive,
                    a.id,
                    a.positionID,
                    a.isAssigned,
                    a.bday,
                    a.gender,
                    a.joinDate,
                    a.sourceHire,
                    a.totalYears,
                    a.totalMonths,
                    a.empType,
                    a.contactName,
                    a.relationship,
                    a.relationshipNumber,
                    a.tin,
                    a.sss,
                    a.pid,
                    a.pagibigID
                FROM
                   hris_user_registration a
                INNER JOIN
                   hris_user_position b 
                ON
                    a.positionID = b.id
                WHERE
                    a.positionID IN (2,3)
                ORDER BY
                    a.userID
            ";
            return builder($con,$sql);
            
        break;
    
        case "display_area_assignment" :
            
            $clientID = $_POST["clientID"];
            
            $sql    = "
                SELECT
                    a.id,
                    a.branchName
                FROM
                    hris_mastefile_client_branches a
                WHERE
                    a.clientID = $clientID
            ";
            $result = mysqli_query($con,$sql);
            
            $json = array();
            while ($row  = mysqli_fetch_row($result)) {
                $json[] = array(
                    'id' => $row[0],
                    'area' => $row[1]
                );
            }
            echo json_encode($json);
            
        break;
    
        case "add_area_assignment" :
            
            $userID    = $_POST["userID"];
            $clientID  = $_POST["clientID"];
            $areaID    = $_POST["areaID"];
            
            $find_query = mysqli_query($con,"SELECT * FROM hris_area_assignment WHERE userID=$userID AND clientID=$clientID AND areaID=$areaID AND isActive = 1");
            if (mysqli_num_rows($find_query) == 0) {
                mysqli_next_result($con);
                
                $query = "INSERT INTO hris_area_assignment (userID,clientID,areaID) VALUES (?,?,?)";
                if ($stmt = mysqli_prepare($con, $query)) {
                    mysqli_stmt_bind_param($stmt,"sss",$userID,$clientID,$areaID);
                    mysqli_stmt_execute($stmt);
                   
                    $error   = false;
                    $color   = "green";
                    $message = "Area has been added"; 
                } else {
                    $error   = true;
                    $color   = "red";
                    $message = "Error adding area"; 
                }
            } else {
                $error   = true;
                $color   = "red";
                $message = "Client and Area combination already added to this user"; 
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    
        case "display_area_client_assign" :
            
            $userID = $_POST["userID"];
            
            $sql = "
                SELECT
                    b.clientsName,
                    c.branchName,
                    c.address,
                    a.id
                FROM
                    hris_area_assignment a
                INNER JOIN
                    hris_masterfile_client b
                ON
                    a.clientID = b.id
                INNER JOIN
                    hris_mastefile_client_branches c
                ON
                    a.areaID = c.id
                WHERE
                    a.isActive = 1
                AND
                    a.userID = $userID
            ";
            return builder($con,$sql);
            
        break;
    
        case "delete_co_ass" :
            
            $id  = $_POST["id"];
            
            $query = "UPDATE hris_area_assignment SET isActive = 0 WHERE id = ?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$id);
                mysqli_stmt_execute($stmt);
               
                $error   = false;
                $color   = "green";
                $message = "Assignment has been deleted"; 
            } else {
                $error   = true;
                $color   = "red";
                $message = "Error deleting assignment"; 
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    
        case "save_contact" :
            
            $contactType = $_POST["contactType"];
            $contactReference = $_POST["contactReference"];
            $contactPerson = $_POST["contactPerson"];
            $isActive = $_POST["isActive"];
            $isNewContact = $_POST["isNewContact"];
            
            if ($isNewContact == 1) {
                
                $find_query = mysqli_query($con,"SELECT * FROM hris_area_assignment WHERE userID=$userID AND clientID=$clientID AND areaID=$areaID AND isActive = 1");
                if (mysqli_num_rows($find_query) == 0) {
                    mysqli_next_result($con);
                    
                    $query = "INSERT INTO hris_area_assignment (userID,clientID,areaID) VALUES (?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sss",$userID,$clientID,$areaID);
                        mysqli_stmt_execute($stmt);
                       
                        $error   = false;
                        $color   = "green";
                        $message = "Area has been added"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error adding area"; 
                    }
                } else {
                    $error   = true;
                    $color   = "red";
                    $message = "Client and Area combination already added to this user"; 
                }
                
                $json[] = array(
                    'error' => $error,
                    'color' => $color,
                    'message' => $message
                );
                echo json_encode($json);
                
            } else {
                
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