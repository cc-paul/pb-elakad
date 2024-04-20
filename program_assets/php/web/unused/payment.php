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
        case "add" :
            
            $ref = date('YmdHis', time());
            $amount = $_POST["amount"];
            
            $query = "INSERT INTO mp_payment_generator (ref,amount,createdBy,dateCreated) VALUES (?,?,?,?)";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"ssss",$ref,$amount,$id,$global_date);
                mysqli_stmt_execute($stmt);
                
                $error   = false;
                $message = "Payment reference has been created. Please give this to the customer " . $ref; 
            } else {
                $error   = true;
                $message = "Error creating payment reference";
            }
            
            $json[] = array(
                'error' => $error,
                'message' => $message
            );
            
            echo json_encode($json);
        break;
    
        case "view" :
            
            $sql = "
                SELECT
                    a.ref,
                    REPLACE(FORMAT(a.amount,2),'.00','') AS amount,
                    a.isUsed,
                    CONCAT(b.fName,' ',b.lName) AS fullName,
                    a.id
                FROM
                    mp_payment_generator a
                INNER JOIN
                    mp_admin_reg b
                ON
                    a.createdBy = b.id
                AND
                    a.isActive = 1
                ORDER BY
                    a.dateCreated DESC;
            ";
            
            return builder($con,$sql);
            
        break;
    
        case "delete" :
            
            $id = $_POST["id"];
            $query = "UPDATE mp_payment_generator SET isActive = 0 WHERE id = ?";
            
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$id);
                mysqli_stmt_execute($stmt);
                
                $error   = false;
                $message = "Payment Reference has been deleted"; 
            } else {
                $error   = true;
                $message = "Error deleting payment reference";
            }
            
            $json[] = array(
                'error' => $error,
                'message' => $message
            );
            
            echo json_encode($json);
            
        break;
    }
    
    mysqli_close($con);
?>