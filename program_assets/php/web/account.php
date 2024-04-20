<?php
    use PHPMailer\PHPMailer\PHPMailer; 
    use PHPMailer\PHPMailer\Exception;
    //
    require '../phpmailer/src/Exception.php';
    require '../phpmailer/src/PHPMailer.php';
    require '../phpmailer/src/SMTP.php';

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
            
            $isNewUser          = $_POST["isNewUser"];
            $userID             = $_POST["userID"];
            $oldEmpID           = $_POST["oldEmpID"];
            $oldUsername        = $_POST["oldUsername"];
            $oldEmailAddress    = $_POST["oldEmailAddress"]; 
            $empID              = $_POST["empID"];
            $firstName          = $_POST["firstName"];
            $middleName         = $_POST["middleName"];
            $lastName           = $_POST["lastName"];
            $emailAddress       = $_POST["emailAddress"];
            $username           = $_POST["username"];
            $mobileNumber       = $_POST["mobileNumber"];
            $isActive           = $_POST["isActive"];
            
            
            $arr_exist       = array();
            
            if ($isNewUser == 1) {
                $find_email = mysqli_query($con,"SELECT * FROM el_user_registration WHERE email = '$emailAddress'");
                if (mysqli_num_rows($find_email) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Email");
                }
                
                $find_user = mysqli_query($con,"SELECT * FROM el_user_registration WHERE username = '$username'");
                if (mysqli_num_rows($find_user) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Username");
                }
                
                
                $find_empid = mysqli_query($con,"SELECT * FROM el_user_registration WHERE employeeID = '$empID'");
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
                    $query = "INSERT INTO el_user_registration (firstName,middleName,lastName,employeeID,email,mobileNumber,username,password,dateCreated)
                    VALUES (?,?,?,?,?,?,?,MD5(?),?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sssssssss",$firstName,$middleName,$lastName,$empID,$emailAddress,$mobileNumber,$username,$username,$global_date);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Account has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving account" . mysqli_error($con);
                    }
                }
            } else {
                if ($oldEmailAddress != $emailAddress) {
                    $find_email = mysqli_query($con,"SELECT * FROM el_user_registration WHERE email = '$emailAddress'");
                    if (mysqli_num_rows($find_email) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Email");
                    }
                }
                
                if ($oldUsername != $username) {
                    $find_user = mysqli_query($con,"SELECT * FROM el_user_registration WHERE username = '$username'");
                    if (mysqli_num_rows($find_user) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Username");
                    }
                }
                
                if ($oldEmpID != $empID) {
                    $find_empid = mysqli_query($con,"SELECT * FROM el_user_registration WHERE employeeID = '$empID'");
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
                    $query = "UPDATE el_user_registration SET firstName=?,middleName=?,lastName=?,employeeID=?,email=?,mobileNumber=?,username=?,isActive=? WHERE id=?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sssssssss",$firstName,$middleName,$lastName,$empID,$emailAddress,$mobileNumber,$username,$isActive,$userID);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Account has been updated successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error updating account" . mysqli_error($con);
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
            
            $query = "UPDATE el_user_registration SET `password` = MD5(username),isPasswordChange = 0 WHERE id = ?";
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
                    a.employeeID,
                    a.username,
                    a.firstName,
                    a.middleName,
                    a.lastName,
                    a.mobileNumber,
                    a.email,
                    IF(a.isActive = 1,'Active','Disabled') AS status,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y %r') AS dateCreated,
                    IF(a.isActive = 1,true,false) AS isActive,
                    a.id
                FROM
                    el_user_registration a
                ORDER BY
                    a.employeeID
            ";
            return builder($con,$sql);
            
        break;
    
        case "display_freelancer" :
            
            $sql = "
                SELECT
                    CONCAT(a.lastName,', ',a.firstName,' ',a.middleName) AS fullName,
                    a.mobileNumber,
                    CONCAT(a.streetName,' ', d.barangayName,' ',c.municipalityName,' (',c.zipCode,') ',' ', b.province) AS fullAddress,
                    DATE_FORMAT(a.birthDate, '%m/%d/%Y') AS birthDate,
                    proper(a.gender) AS gender,
                    emailAddress,
                    a.`status`,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y %r') AS dateCreated,
                    a.`status`,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y %r') AS dateCreated,(
                        SELECT
                            GROUP_CONCAT(y.service) AS services
                        FROM
                            el_appaccount_services x 
                        INNER JOIN
                            el_service y
                        ON
                            x.serviceID = y.id
                        WHERE
                            x.userID = a.id
                        GROUP BY
                            x.userID
                    ) AS services,
                    a.id
                FROM
                    el_appaccount_registration a
                INNER JOIN
                    el_province b
                ON
                    a.provinceID = b.id
                INNER JOIN
                    el_municipality c
                ON
                    a.municipalityID = c.id
                INNER JOIN
                    el_barangay d 
                ON
                    a.barangayID = d.id
                WHERE
                    a.isRegularUser = 0
                ORDER BY
                    a.dateCreated DESC
            ";
            return builder($con,$sql);
            
        break;
        
        case "change_freelance_status" :
            
            $id     = $_POST["id"];
            $status = $_POST["status"];
            $messageEmail = "";
            $freelanceEmail = $_POST["freelanceEmail"];
            $freelanceFullName = $_POST["freelanceFullName"];
    
            if ($status == "Approved") {
                $messageEmail = "Congratulations! Your account has been approved. You may now use the application";
            } else if ($status == "Declined") {
                $messageEmail = "Were sorry to inform you that your account has been declined";
            } else {
                $messageEmail = "Were sorry to inform you that your account has been banned from using our application";
            }
            
            $query = "UPDATE el_appaccount_registration SET `status` = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"ss",$status,$id);
                mysqli_stmt_execute($stmt);
                
                $error   = false;
                $color   = "green";
                $message = "Status has been updated"; 
            } else {
                $error   = true;
                $color   = "red";
                $message = "Error updating status";
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
            $mail = new PHPMailer(true);                              
            try {
                $mail->isSMTP(); // using SMTP protocol                                     
                $mail->Host = 'smtp.gmail.com'; // SMTP host as gmail 
                $mail->SMTPAuth = true;  // enable smtp authentication                             
                $mail->Username = 'servicio.ggploternity@gmail.com';  // sender gmail host              
                $mail->Password = 'psdbqalpbbkgwavw'; // sender gmail host password                          
                $mail->SMTPSecure = 'tls';  // for encrypted connection                           
                $mail->Port = 587;   // port for SMTP     
            
                $mail->setFrom('servicio.ggploternity@gmail.com', "E-Servicio"); // sender's email and name
                $mail->addAddress($freelanceEmail, str_replace(",","",$freelanceFullName));  // receiver's email and name
            
                $mail->Subject = 'Freelance Approval Status';
                $mail->Body    = $messageEmail;
            
                $mail->send();
                //echo 'Message has been sent';
            } catch (Exception $e) { // handle error.
                //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
            
        break;
    
        case "display_freelance_image" :
            
            $id     = $_POST["id"];
            
            $sql    = "
                SELECT
                    a.imageLink
                FROM
                    el_appaccount_ids a
                WHERE
                    a.userID  = $id
            ";
            $result = mysqli_query($con,$sql);
            
            $json = array();
            while ($row  = mysqli_fetch_row($result)) {
                $json[] = array(
                    'imageLink' => $row[0],
                );
            }
            echo json_encode($json);
            
        break;
    }
    
    mysqli_close($con);
?>