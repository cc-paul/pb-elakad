<?php
    if(!isset($_SESSION)) { session_start(); } 
    include 'appkey_generator.php';
    include dirname(__FILE__,2) . '/config.php';
    include $main_location . '/connection/conn.php';
    include '../builder/builder_select.php';
    include '../builder/builder_table.php';
    
    $command = $_POST["command"];
    $id      = $_SESSION["id"];
    
    switch ($command) {
        case "display_admin" :
            
            $sql = "
                SELECT
                    a.id,
                    a.fName,
                    a.lName,
                    a.email,
                    a.username,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y, %r') AS dateCreated,
                    CONCAT(a.fName,' ',a.lName) AS fullName,
                    IF(a.isActive = 1,'Active','Inactive') AS `status`
                FROM
                    mp_admin_reg a
                INNER JOIN
                    mp_admin_reg b
                ON
                    a.id = b.id
                ORDER BY
                    a.dateCreated DESC;
            ";
            return builder($con,$sql);
            
        break;
    
        case "admin_save" :
            
            $userid       = $_POST["userid"];
            $isNewAccount = $_POST["isNewAccount"];
            $fname        = $_POST["fname"];
            $lname        = $_POST["lname"];
            $email        = $_POST["email"];
            $username     = $_POST["username"];
            $isactive     = $_POST["isactive"];
            
            $old_email    = $_POST["old_email"];
            $old_username = $_POST["old_username"];
            
            $error   = false;
            $message = "";
            $json    = array();
            
            $arr_exist = array();
            
            if ($isNewAccount == 1) {
                $find_email = mysqli_query($con,"SELECT * FROM mp_admin_reg WHERE email = '$email'");
                if (mysqli_num_rows($find_email) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Email");
                }
                
                $find_user = mysqli_query($con,"SELECT * FROM mp_admin_reg WHERE username = '$username'");
                if (mysqli_num_rows($find_user) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Username");
                }
                
                if (count($arr_exist) != 0) {
                    $error   = true;
                    $message = implode(" and ",$arr_exist) . " already exist";
                    
                    $json[] = array(
                        'error' => $error,
                        'message' => $message
                    );
                } else {
                    $query = "INSERT INTO mp_admin_reg (fName,lName,email,username,`password`,dateCreated,createdBy) VALUES (?,?,?,?,MD5(?),?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sssssss",$fname,$lname,$email,$username,$username,$global_date,$id);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $message = "Account has been save successfully"; 
                    } else {
                        $error   = true;
                        $message = "Error saving account";
                    }
                    
                    $json[] = array(
                        'error' => $error,
                        'message' => $message
                    );
                }
            } else {
                if ($email != $old_email) {
                    $find_email = mysqli_query($con,"SELECT * FROM mp_admin_reg WHERE email = '$email'");
                    if (mysqli_num_rows($find_email) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Email");
                    }
                }
                
                if ($username != $old_username) {
                    $find_user = mysqli_query($con,"SELECT * FROM mp_admin_reg WHERE username = '$username'");
                    if (mysqli_num_rows($find_user) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Username");
                    }
                }
                
                if (count($arr_exist) != 0) {
                    $error   = true;
                    $message = implode(" and ",$arr_exist) . " already exist";
                    
                    $json[] = array(
                        'error' => $error,
                        'message' => $message
                    );
                } else {
                    $query = "UPDATE mp_admin_reg SET fName=?,lName=?,email=?,username=?,isActive=?,updatedBy=?,dateUpdated=? WHERE id=?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssssssss",$fname,$lname,$email,$username,$isactive,$id,$global_date,$userid);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $message = "Account has been updated successfully"; 
                    } else {
                        $error   = true;
                        $message = "Error updating account";
                    }
                    
                    $json[] = array(
                        'error' => $error,
                        'message' => $message
                    );
                }
            }
            
            echo json_encode($json);
        break;
    
        case "account_reset" :
            
            $userid  = $_POST["userid"];
            
            $error   = false;
            $message = "";
            $json    = array();
            
            $query = "UPDATE mp_admin_reg SET password=MD5(username),isPasswordChange=0 WHERE id=?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$userid);
                mysqli_stmt_execute($stmt);
                
                $error   = false;
                $message = "Password has been reset"; 
            } else {
                $error   = true;
                $message = "Error reseting password";
            }
            
            $json[] = array(
                'error' => $error,
                'message' => $message
            );
            
            echo json_encode($json);
        break;
    
        case "display_category" :
            
            $sql = "
                SELECT
                    a.category,
                    a.description,
                    CONCAT(b.fName,' ',b.lName) AS createdBy,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y, %r') AS dateCreated,
                    CONCAT(c.fName,' ',c.lName) AS UpdatedBy,
                    DATE_FORMAT(a.dateUpdated,'%M %d %Y, %r') AS dateUpdated,
                    IF(a.isActive = 1,'Active','Inactive') AS `status`,
                    a.id
                FROM
                    mp_admin_category a
                INNER JOIN
                    mp_admin_reg b
                ON
                    a.createdBy = b.id
                LEFT JOIN
                    mp_admin_reg c
                ON
                    a.updatedBy = c.id
                ORDER BY
                    a.dateCreated DESC;
            ";
            return builder($con,$sql);
            
        break;
    
        case "category_save" :
            
            $cname         = $_POST["cname"];
            $cdesc         = $_POST["cdesc"];
            $isactive      = $_POST["isactive"];
            $isnewcategory = $_POST["isnewcategory"];
            $oldcname      = $_POST["oldcname"];
            $catid         = $_POST["catid"];
            
            
            $error     = false;
            $message   = "";
            $json      = array();
            $arr_exist = array();
            
            if ($isnewcategory == 1) {
                $find_category = mysqli_query($con,"SELECT * FROM mp_admin_category WHERE category = '$cname'");
                if (mysqli_num_rows($find_category) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Category");
                }
                
                if (count($arr_exist) == 0) {
                    $query = "INSERT INTO mp_admin_category (category,description,createdBy,dateCreated) VALUES (?,?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssss",$cname,$cdesc,$id,$global_date);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $message = "Category has been added"; 
                    } else {
                        $error   = true;
                        $message = "Error adding category";
                    }
                } else {
                    $error   = true;
                    $message = implode(" and ",$arr_exist) . " already exist";
                }
            } else {
                if ($cname != $oldcname) {
                    $find_category = mysqli_query($con,"SELECT * FROM mp_admin_category WHERE category = '$cname'");
                    if (mysqli_num_rows($find_category) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Category");
                    }
                }
                
                if (count($arr_exist) == 0) {
                    $query = "UPDATE mp_admin_category SET category=?,description=?,updatedBy=?,dateUpdated=?,isActive=? WHERE id =?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssssss",$cname,$cdesc,$id,$global_date,$isactive,$catid);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $message = "Category has been updated"; 
                    } else {
                        $error   = true;
                        $message = "Error updating category";
                    }
                } else {
                    $error   = true;
                    $message = implode(" and ",$arr_exist) . " already exist";
                }
            }
            
            $json[] = array(
                'error' => $error,
                'message' => $message
            );
            
            echo json_encode($json);
            
        break;
        
        case "display_services" :
            
            $sql = "
                SELECT
                    a.service,
                    a.description,
                    b.category,
                    REPLACE(FORMAT(a.price,2),'.00','') AS price,
                    CONCAT(c.fName,' ',c.lName) AS createdBy,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y, %r') AS dateCreated,
                    CONCAT(d.fName,' ',d.lName) AS UpdatedBy,
                    DATE_FORMAT(a.dateUpdated,'%M %d %Y, %r') AS dateUpdated,
                    IF(a.isActive = 1,'Active','Inactive') AS `status`,
                    a.id,
                    a.category_id
                FROM
                    mp_admin_services a
                INNER JOIN
                    mp_admin_category b
                ON
                    a.category_id = b.id
                INNER JOIN
                    mp_admin_reg c
                ON
                    a.createdBy = c.id
                LEFT JOIN
                    mp_admin_reg d
                ON
                    a.updatedBy = d.id
            ";
            return builder($con,$sql);
            
        break;
    
        case "save_service" :
            
            $sid          = $_POST["sid"];
            $sname        = $_POST["sname"];
            $oldsname     = $_POST["oldsname"];
            $description  = $_POST["description"];
            $catid        = $_POST["catid"];
            $price        = $_POST["price"];
            $isactive     = $_POST["isactive"];
            $isnewservice = $_POST["isnewservice"];
            
            $error     = false;
            $message   = "";
            $json      = array();
            $arr_exist = array();
            
            if ($isnewservice) {
                $find_service = mysqli_query($con,"SELECT * FROM mp_admin_services WHERE service = '$sname'");
                if (mysqli_num_rows($find_service) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Service");
                }
                
                if (count($arr_exist) == 0) {
                    $query = "INSERT INTO mp_admin_services (service,description,category_id,price,createdBy,dateCreated) VALUES (?,?,?,?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssssss",$sname,$description,$catid,$price,$id,$global_date);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $message = "Service has been added"; 
                    } else {
                        $error   = true;
                        $message = "Error adding service";
                    }
                } else {
                    $error   = true;
                    $message = implode(" and ",$arr_exist) . " already exist";
                }
            } else {
                if ($sname != $oldsname) {
                    $find_service = mysqli_query($con,"SELECT * FROM mp_admin_services WHERE service = '$sname'");
                    if (mysqli_num_rows($find_service) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Service");
                    }
                }
                
                if (count($arr_exist) == 0) {
                    $query = "UPDATE mp_admin_services SET service=?,description=?,category_id=?,price=?,updatedBy=?,dateUpdated=?,isActive=? WHERE id =?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssssssss",$sname,$description,$catid,$price,$id,$global_date,$isactive,$sid);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $message = "Service has been added"; 
                    } else {
                        $error   = true;
                        $message = "Error adding service";
                    }
                } else {
                    $error   = true;
                    $message = implode(" and ",$arr_exist) . " already exist";
                }
            }
        
            $json[] = array(
                'error' => $error,
                'message' => $message
            );
            
            echo json_encode($json);
            
        break;
    
        case "display_therapist" :
            
            $sql = "
                SELECT
                    a.id,
                    a.fName,
                    a.lName,
                    a.email,
                    a.username,
                    a.mobileNumber,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y, %r') AS dateCreated,
                    CONCAT(a.fName,' ',a.lName) AS fullName,
                    IF(a.isActive = 1,'Active','Inactive') AS `status`,
                    b.`name` AS position,
                    b.id AS positionID
                FROM
                    mp_admin_therapist a
                INNER JOIN
                    mp_admin_position b 
                ON
                    a.positionID = b.id
                WHERE
                    a.isActive = 1
                ORDER BY
                    a.dateCreated DESC;
            ";
            return builder($con,$sql);
            
        break;
    
        case "thera_save" :
            
            $userid       = $_POST["userid"];
            $isNewAccount = $_POST["isNewAccount"];
            $fname        = $_POST["fname"];
            $lname        = $_POST["lname"];
            $email        = $_POST["email"];
            $username     = $_POST["username"];
            $isactive     = $_POST["isactive"];
            $mobileNumber = $_POST["mobileNumber"];
            $positionID   = $_POST["positionID"];
            
            $old_email    = $_POST["old_email"];
            $old_username = $_POST["old_username"];
            
            $error   = false;
            $message = "";
            $json    = array();
            
            $arr_exist = array();
            
            if ($isNewAccount == 1) {
                $find_email = mysqli_query($con,"SELECT * FROM mp_admin_therapist WHERE email = '$email'");
                if (mysqli_num_rows($find_email) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Email");
                }
                
                $find_user = mysqli_query($con,"SELECT * FROM mp_admin_therapist WHERE username = '$username'");
                if (mysqli_num_rows($find_user) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Username");
                }
                
                if (count($arr_exist) != 0) {
                    $error   = true;
                    $message = implode(" and ",$arr_exist) . " already exist";
                    
                    $json[] = array(
                        'error' => $error,
                        'message' => $message
                    );
                } else {
                    $query = "INSERT INTO mp_admin_therapist (fName,lName,email,username,`password`,dateCreated,createdBy,mobileNumber,positionID) VALUES (?,?,?,?,MD5(?),?,?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sssssssss",$fname,$lname,$email,$username,$username,$global_date,$id,$mobileNumber,$positionID);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $message = "Account has been save successfully"; 
                    } else {
                        $error   = true;
                        $message = "Error saving account";
                    }
                    
                    $json[] = array(
                        'error' => $error,
                        'message' => $message
                    );
                }
            } else {
                if ($email != $old_email) {
                    $find_email = mysqli_query($con,"SELECT * FROM mp_admin_therapist WHERE email = '$email'");
                    if (mysqli_num_rows($find_email) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Email");
                    }
                }
                
                if ($username != $old_username) {
                    $find_user = mysqli_query($con,"SELECT * FROM mp_admin_therapist WHERE username = '$username'");
                    if (mysqli_num_rows($find_user) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Username");
                    }
                }
                
                if (count($arr_exist) != 0) {
                    $error   = true;
                    $message = implode(" and ",$arr_exist) . " already exist";
                    
                    $json[] = array(
                        'error' => $error,
                        'message' => $message
                    );
                } else {
                    $query = "UPDATE mp_admin_therapist SET fName=?,lName=?,email=?,username=?,isActive=?,updatedBy=?,dateUpdated=?,mobileNumber=?,positionID=? WHERE id=?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssssssssss",$fname,$lname,$email,$username,$isactive,$id,$global_date,$mobileNumber,$positionID,$userid);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $message = "Account has been updated successfully"; 
                    } else {
                        $error   = true;
                        $message = "Error updating account";
                    }
                    
                    $json[] = array(
                        'error' => $error,
                        'message' => $message
                    );
                }
            }
            
            echo json_encode($json);
        break;
    
        case "thera_reset" :
            
            $userid  = $_POST["userid"];
            
            $error   = false;
            $message = "";
            $json    = array();
            
            $query = "UPDATE mp_admin_therapist SET password=MD5(username),isPasswordChange=0 WHERE id=?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$userid);
                mysqli_stmt_execute($stmt);
                
                $error   = false;
                $message = "Password has been reset"; 
            } else {
                $error   = true;
                $message = "Error reseting password";
            }
            
            $json[] = array(
                'error' => $error,
                'message' => $message
            );
            
            echo json_encode($json);
        break;
    
        case "display_branch" :
            
            $sql = "
                SELECT
                    a.branchName,
                    a.address,
                    CONCAT(b.fName,' ',b.lName) AS createdBy,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y, %r') AS dateCreated,
                    CONCAT(c.fName,' ',c.lName) AS UpdatedBy,
                    DATE_FORMAT(a.dateUpdated,'%M %d %Y, %r') AS dateUpdated,
                    IF(a.isActive = 1,'Active','Inactive') AS `status`,
                    a.id
                FROM
                    mp_admin_branch a
                INNER JOIN
                    mp_admin_reg b
                ON
                    a.createdBy = b.id
                LEFT JOIN
                    mp_admin_reg c
                ON
                    a.updatedBy = c.id
                ORDER BY
                    a.dateCreated DESC;
            ";
            return builder($con,$sql);
            
        break;
    
        case "branch_save" :
            
            $branch      = $_POST["branch"];
            $address     = $_POST["address"];
            $isactive    = $_POST["isactive"];
            $isnewbranch = $_POST["isnewbranch"];
            $oldbranch   = $_POST["oldbranch"];
            $branchid    = $_POST["branchid"];
            
            $error     = false;
            $message   = "";
            $json      = array();
            $arr_exist = array();
            
            if ($isnewbranch == 1) {
                $find_branch = mysqli_query($con,"SELECT * FROM mp_admin_branch WHERE branchName = '$branch'");
                if (mysqli_num_rows($find_branch) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Branch");
                }
                
                if (count($arr_exist) == 0) {
                    $query = "INSERT INTO mp_admin_branch (branchName,address,createdBy,dateCreated) VALUES (?,?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssss",$branch,$address,$id,$global_date);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $message = "Branch has been added"; 
                    } else {
                        $error   = true;
                        $message = "Error adding branch";
                    }
                } else {
                    $error   = true;
                    $message = implode(" and ",$arr_exist) . " already exist";
                }
            } else {
                if ($branch != $oldbranch) {
                    $find_branch = mysqli_query($con,"SELECT * FROM mp_admin_branch WHERE branchName = '$branch'");
                    if (mysqli_num_rows($find_branch) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Branch");
                    }
                }
                
                if (count($arr_exist) == 0) {
                    $query = "UPDATE mp_admin_branch SET branchName=?,address=?,updatedBy=?,dateUpdated=?,isActive=? WHERE id =?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssssss",$branch,$address,$id,$global_date,$isactive,$branchid);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $message = "Branch has been updated"; 
                    } else {
                        $error   = true;
                        $message = "Error updating branch";
                    }
                } else {
                    $error   = true;
                    $message = implode(" and ",$arr_exist) . " already exist";
                }
            }
            
            $json[] = array(
                'error' => $error,
                'message' => $message
            );
            
            echo json_encode($json);
            
        break;
    
        case "thera_sched_add" :
            
            $userid   = $_POST["userid"];
            $dayID    = $_POST["dayID"];
            $timeFrom = $_POST["timeFrom"];
            $timeTo   = $_POST["timeTo"];
            
            $error     = false;
            $message   = "";
            $json      = array();
            $arr_exist = array();
            
            $find_query = mysqli_query($con,"SELECT * FROM mp_admin_schedules WHERE therapistID = $userid AND dayID = $dayID AND timeFrom = '$timeFrom' AND timeTo = '$timeTo' AND isActive = 1");
            if (mysqli_num_rows($find_query) == 0) {
                mysqli_next_result($con);
                
                $query = "INSERT INTO mp_admin_schedules (therapistID,dayID,timeFrom,timeTo) VALUES (?,?,?,?)";
                if ($stmt = mysqli_prepare($con, $query)) {
                    mysqli_stmt_bind_param($stmt,"ssss",$userid,$dayID,$timeFrom,$timeTo);
                    mysqli_stmt_execute($stmt);
                    
                    $error   = false;
                    $message = "Schedule has been saved successfully";
                } else {
                    $error   = true;
                    $message = "Error saving schedule";
                }
            } else {
                $error   = true;
                $message = "Schedule already exist";
            }
            
            $json[] = array(
                'error' => $error,
                'message' => $message
            );
            
            echo json_encode($json);
            
        break;
    
        case "display_sched" :
            
            $userid   = $_POST["userid"];
            
            $sql = "
                SELECT 
                    b.`day`,
                    TIME_FORMAT(a.timeFrom, '%h:%i %p') AS timeFrom,
                    TIME_FORMAT(a.timeTo, '%h:%i %p') AS timeTo,
                    a.id
                FROM
                    mp_admin_schedules a
                INNER JOIN
                    mp_admin_days b 
                ON 
                    a.dayID = b.id
                WHERE
                    a.isActive = 1
                AND
                    a.therapistID = $userid
                ORDER BY
                    a.dayID ASC,
                    a.timeFrom ASC
            ";
            return builder($con,$sql);
            
        break;
    
        case "thera_sched_delete" :
            
            $id        = $_POST["id"];
            $error     = false;
            $json      = array();
            
            $query = "UPDATE mp_admin_schedules SET isActive = 0 WHERE id=?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$id);
                mysqli_stmt_execute($stmt);
                
                $error   = false;
            } else {
                $error   = true;
            }
            
            $json[] = array(
                'error' => $error
            );
            
            echo json_encode($json);
            
        break;
    }
    
    mysqli_close($con);
?>