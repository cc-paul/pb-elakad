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
    $userID  = $_SESSION["id"];
    
    switch ($command) {
        case "save_news" :
            
            $isNewNews = $_POST["isNewNews"];
            $title = $_POST["title"];
            $story = $_POST["story"];
            $isActive = $_POST["isActive"];
            $oldTitle = $_POST["oldTitle"];
            $id = $_POST["id"];
            
            if ($isNewNews == 1) {
                $find_query = mysqli_query($con,"SELECT * FROM hrms_newsfeed WHERE title = '$title'");
                if (mysqli_num_rows($find_query) == 0) {
                    mysqli_next_result($con);
                    
                    $query = "INSERT INTO hrms_newsfeed (title,story,isActive,createdBy,dateCreated) VALUES (?,?,?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sssss",$title,$story,$isActive,$userID,$global_date);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Story has been saved successfully";
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving story";
                    }
                } else {
                    $error   = true;
                    $color   = "red";
                    $message = "A story with same title already exist";
                }
            } else {
                $isExist = 0;
                
                if ($title != $oldTitle) {
                    $find_query = mysqli_query($con,"SELECT * FROM hrms_newsfeed WHERE title = '$title'");
                    if (mysqli_num_rows($find_query) == 0) {
                        mysqli_next_result($con);
                    
                        $isExist = 0;    
                    } else {
                        $isExist = 1;
                    }
                }
                
                if ($isExist == 1) {
                    $error   = true;
                    $color   = "red";
                    $message = "A story with same title already exist";
                } else {
                    $query = "UPDATE hrms_newsfeed SET title=?,story=?,isActive=? WHERE id=?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssss",$title,$story,$isActive,$id);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Story has been saved successfully";
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving story";
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
    
        case "display_feed" :
            
            $sql = "
                SELECT
                    a.id,
                    a.title,
                    a.story,
                    CONCAT(b.firstName,' ',b.middleName,' ',b.lastName) AS fullName,
                    DATE_FORMAT(a.dateCreated,'%M %d %Y %r') AS fdateCreated,
                    IF(a.isActive = 1,'Active','Disabled') AS status,
                    a.story AS unfStory,
                    a.isActive
                FROM
                    hrms_newsfeed a
                INNER JOIN
                    hrms_user_registration b
                ON
                    a.createdBy = b.id
                ORDER BY
                    a.dateCreated DESC
            ";
            return builder($con,$sql);
            
        break;
    
        case "display_image" :
            
            $id = $_POST["id"];
            
            $sql = "SELECT id,CONCAT(filename,'.png') FROM hrms_newsfeed_image WHERE newsFeedID = $id AND isActive = 1";
            $result = mysqli_query($con,$sql);
            
            $json = array();
            while ($row  = mysqli_fetch_row($result)) {
                $json[] = array(
                    'id' => $row[0],
                    'fileName' => $row[1]
                );
            }
            echo json_encode($json);
            
        break;
    
        case "delete_image" :
            
            $id = $_POST["id"];
            
            $query = "UPDATE hrms_newsfeed_image SET isActive=0 WHERE id=?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$id);
                mysqli_stmt_execute($stmt);
                
                $error   = false;
                $color   = "green";
            } else {
                $error   = true;
                $color   = "red";
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color
            );
            echo json_encode($json);
            
        break;
    }
    
    mysqli_close($con);
?>