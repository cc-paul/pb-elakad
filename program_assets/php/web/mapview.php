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
        case "save_building" :
            
            $isNewBuilding = $_POST["isNewBuilding"];
            $oldBuildingId = $_POST["oldBuildingId"];
            $oldBuildingName = $_POST["oldBuildingName"];
            $buildingName = $_POST["buildingName"];
            $latLong = $_POST["latLong"];
            $ndki = $_POST["ndki"];
            $isActive = $_POST["isActive"];
            $arr_exist = array();
            
            
            if ($isNewBuilding == 1) {
                $find_building = mysqli_query($con,"SELECT * FROM el_map_masterfile WHERE buildingName = '$buildingName'");
                if (mysqli_num_rows($find_building) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Building");
                }
                
                if (count($arr_exist) == 0) {
                    $query = "INSERT INTO el_map_masterfile (buildingName,latLong,ndki,isActive,createdBy,dateCreated) 
                    VALUES (?,?,?,?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"ssssss",$buildingName,$latLong,$ndki,$isActive,$_SESSION["id"],$global_date);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Building has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving building" . mysqli_error($con);
                    }
                } else {
                    $error   = true;
                    $color   = "orange";
                    $message = "Building already exist";
                }
            } else {
                if (strtolower($buildingName) != strtolower($oldBuildingName)) {
                    $find_building = mysqli_query($con,"SELECT * FROM el_map_masterfile WHERE buildingName = '$buildingName'");
                    if (mysqli_num_rows($find_building) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Building");
                    }
                }
                
                $query = "UPDATE el_map_masterfile SET buildingName=?,latLong=?,ndki=?,isActive=? WHERE id=?";
                if ($stmt = mysqli_prepare($con, $query)) {
                    mysqli_stmt_bind_param($stmt,"sssss",$buildingName,$latLong,$ndki,$isActive,$oldBuildingId);
                    mysqli_stmt_execute($stmt);
                    
                    $error   = false;
                    $color   = "green";
                    $message = "Building has been save successfully"; 
                } else {
                    $error   = true;
                    $color   = "red";
                    $message = "Error saving building" . mysqli_error($con);
                }
            }            
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    
        case "display_building" :
            
            $sql = "
                SELECT
                    a.id,
                    a.buildingName,
                    a.latLong,
                    a.ndki,
                    IF(a.isActive,'Active','Disabled') AS `status`,
                    a.isActive
                FROM
                    el_map_masterfile a
                ORDER BY
                    a.dateCreated DESC
            ";
            return builder($con,$sql);
        
        break;
    
        case "display_menu" :
            
            $search = $_POST["search"];
            
            $sql    = "
                SELECT
                    a.id,
                    a.buildingName,
                    a.latLong,
                    a.ndki
                FROM
                    el_map_masterfile a
                WHERE
                    a.isActive = 1
                AND
                    a.buildingName LIKE '%$search%'
                ORDER BY
                    a.buildingName ASC
            ";
            $result = mysqli_query($con,$sql);
            
            $json = array();
            while ($row  = mysqli_fetch_row($result)) {
                $json[] = array(
                    'id' => $row[0],
                    'buildingName' => $row[1],
                    'latLong' => $row[2],
                    'ndki' => $row[3]
                );
            }
            echo json_encode($json);
            
        break;
    
        case "update_location_admin" :
            
            $visitorID = $_POST['visitorsID'];
            $latLong = $_POST["latLong"];
            $buildingName = $_POST["buildingName"];
            
            $query = "DELETE FROM el_latlong_activity WHERE visitorsID = ?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$visitorID);
                mysqli_stmt_execute($stmt);
                
                $query = "INSERT INTO el_latlong_activity (visitorsID,currentLatLong,destination) VALUES (?,?,?)";
                if ($stmt = mysqli_prepare($con, $query)) {
                    mysqli_stmt_bind_param($stmt,"sss",$visitorID,$latLong,$buildingName);
                    mysqli_stmt_execute($stmt);
                    
                    $error   = false;
                    $color   = "green";
                    $message = "Location has been updated"; 
                } else {
                    $error   = true;
                    $color   = "red";
                    $message = "Error adding location"; 
                }
            } else {
                $error   = true;
                $color   = "red";
                $message = "Error deleting old location"; 
            }
            
        break;
    
        case "log_me_out" :
            
            $visitorID = $_POST['visitorsID'];
            
            $query = "DELETE FROM el_latlong_activity WHERE visitorsID = ?";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt,"s",$visitorID);
                mysqli_stmt_execute($stmt);
                
                $query = "UPDATE el_map_activity SET isActive = 0 WHERE visitorsID = ?";
                if ($stmt = mysqli_prepare($con, $query)) {
                    mysqli_stmt_bind_param($stmt,"s",$visitorID);
                    mysqli_stmt_execute($stmt);
                    
                    $error   = false;
                    $color   = "green";
                    $message = "Logged out successfully"; 
                } else {
                    $error   = true;
                    $color   = "red";
                    $message = "Error deleting reasons"; 
                }
            } else {
                $error   = true;
                $color   = "red";
                $message = "Error deleting activity"; 
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    
        case "show_people" :
            
            $sql    = "
                SELECT
                    a.visitorsID,
                    a.currentLatLong,
                    a.destination,
                    b.fullName,
                    b.mobileNumber,
                    b.completeAddress,
                    b.reason
                FROM
                    el_latlong_activity a 
                INNER JOIN
                    el_map_activity b
                ON
                    a.visitorsID = b.visitorsID AND b.isActive = 1
            ";
            $result = mysqli_query($con,$sql);
            
            $json = array();
            while ($row  = mysqli_fetch_row($result)) {
                $json[] = array(
                    'visitorsID' => $row[0],
                    'currentLatLong' => $row[1],
                    'destination' => $row[2],
                    'fullName' => $row[3],
                    'mobileNumber' => $row[4],
                    'completeAddress' => $row[5],
                    'reason' => $row[6],
                );
            }
            echo json_encode($json);
            
        break;
    }
    
    mysqli_close($con);
?>