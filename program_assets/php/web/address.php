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
        case "save_province" :
        
            $provinceID      = $_POST["provinceID"];
            $isNewProvince   = $_POST["isNewProvince"];
            $province        = $_POST["province"];
            $oldProvinceName = $_POST["oldProvinceName"];
            $isActive        = $_POST["isActive"];
            $arr_exist       = array();
            
            if ($isNewProvince == 1) {
                $find_province = mysqli_query($con,"SELECT * FROM es_province WHERE province = '$province'");
                if (mysqli_num_rows($find_province) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Province");
                }
                
                if (count($arr_exist) == 0) {
                    $query = "INSERT INTO es_province (province,isActive,dateCreated)
                    VALUES (?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sss",$province,$isActive,$global_date);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Province has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving province" . mysqli_error($con);
                    }
                } else {
                    $error   = true;
                    $color   = "orange";
                    $message = "Province already exist";
                }
            } else {
                if ($province != $oldProvinceName) {
                    $find_province = mysqli_query($con,"SELECT * FROM es_province WHERE province = '$province'");
                    if (mysqli_num_rows($find_province) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Province");
                    }
                }
                
                if (count($arr_exist) == 0) {
                    $query = "UPDATE es_province SET province=?,isActive=? WHERE id=?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sss",$province,$isActive,$provinceID);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Province has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving province" . mysqli_error($con);
                    }
                } else {
                    $error   = true;
                    $color   = "orange";
                    $message = "Province already exist";
                }
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    
        case "display_province" :
            
            $sql = "
                SELECT
                    a.province,
                    IF(a.isActive = 1,'Active','Disabled') AS status,
                    DATE_FORMAT(a.dateCreated,'%m/%d/%Y') AS dateCreated,
                    IF(a.isActive = 1,true,false) AS isActive,
                    a.id
                FROM
                    es_province a
                ORDER BY
                    a.dateCreated DESC;
            ";
            return builder($con,$sql);
            
        break;
    
        case "display_municipality" :
            
            $sql = "
                SELECT
                    b.province,
                    a.municipalityName,
                    a.zipCode,
                    IF(a.isActive = 1,'Active','Disabled') AS status,
                    DATE_FORMAT(a.dateCreated,'%m/%d/%Y') AS dateCreated,
                    IF(a.isActive = 1,true,false) AS isActive,
                    a.id,
                    a.provinceID
                FROM
                    es_municipality a
                INNER JOIN
                    es_province b
                ON
                    a.provinceID = b.id
                ORDER BY
                    a.dateCreated DESC;
            ";
            return builder($con,$sql);
            
        break;
    
        case "select_municipality" :
            
            $provinceID = $_POST["provinceID"];
            
            $sql = "
                SELECT
                    a.id,
                    a.municipalityName
                FROM
                    es_municipality a
                WHERE
                    a.isActive = 1
                AND
                    a.provinceID = $provinceID
            ";
            
            $result = mysqli_query($con,$sql);
            
            $json = array();
            while ($row  = mysqli_fetch_row($result)) {
                $json[] = array(
                    'id' => $row[0],
                    'municipalityName' => $row[1]
                );
            }
            echo json_encode($json);
            
        break;
    
        case "save_municipality" :
            
            $isNewMunicipality = $_POST["isNewMunicipality"];
            $provinceID = $_POST["provinceID"];
            $municipality = $_POST["municipality"];
            $zipCode = $_POST["zipCode"];
            $isActive = $_POST["isActive"];
            $oldMunicipalityName = $_POST["oldMunicipalityName"];
            $oldZipCode = $_POST["oldZipCode"];
            $municipalityID = $_POST["municipalityID"];
            
            $arr_exist       = array();
            
            if ($isNewMunicipality == 1) {
                $find_municipality = mysqli_query($con,"SELECT * FROM es_municipality WHERE municipalityName = '$municipality' OR zipCode = '$zipCode'");
                if (mysqli_num_rows($find_municipality) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Municipality");
                }
                
                if (count($arr_exist) == 0) {
                    $query = "INSERT INTO es_municipality (provinceID,municipalityName,zipCode,isActive,dateCreated) VALUES (?,?,?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sssss",$provinceID,$municipality,$zipCode,$isActive,$global_date);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Municipality has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving municipality" . mysqli_error($con);
                    }
                } else {
                    $error   = true;
                    $color   = "orange";
                    $message = "Municipality already exist";
                }
            } else {
                if ($oldMunicipalityName != $municipality || $zipCode != $oldZipCode) {
                    $find_municipality = mysqli_query($con,"SELECT * FROM es_municipality WHERE municipalityName = '$municipality' OR zipCode = '$zipCode'");
                    if (mysqli_num_rows($find_municipality) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Municipality");
                    }
                }
                
                if (count($arr_exist) == 0) {
                    $query = "UPDATE es_municipality SET provinceID=?,municipalityName=?,zipCode=?,isActive=? WHERE id=?";
                    
                    
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sssss",$provinceID,$municipality,$zipCode,$isActive,$municipalityID);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Municipality has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving municipality" . mysqli_error($con);
                    }
                } else {
                    $error   = true;
                    $color   = "orange";
                    $message = "Municipality already exist";
                }
            }
            
            $json[] = array(
                'error' => $error,
                'color' => $color,
                'message' => $message
            );
            echo json_encode($json);
            
        break;
    
        case "display_brgy" :
            
            $sql = "
                SELECT
                    b.province,
                    c.municipalityName,
                    c.zipCode,
                    a.barangayName,
                    IF(a.isActive = 1,'Active','Disabled') AS status,
                    DATE_FORMAT(a.dateCreated,'%m/%d/%Y') AS dateCreated,
                    a.municipalityID,
                    a.provinceID,
                    a.id,
                    a.isActive
                FROM
                    es_barangay a 
                INNER JOIN
                    es_province b
                ON
                    a.provinceID = b.id
                INNER JOIN
                    es_municipality c
                ON
                    a.municipalityID = c.id
                ORDER BY
                    a.dateCreated DESC
            ";
            return builder($con,$sql);
            
        break;
    
        case "save_barangay" :
            
            $provinceID = $_POST["provinceID"];
            $municipalityID = $_POST["municipalityID"];
            $barangay = $_POST["barangay"];
            $isActive = $_POST["isActive"];
            $oldBrgyProvince = $_POST["oldBrgyProvince"];
            $oldBrgyMunicipality = $_POST["oldBrgyMunicipality"];
            $oldBrgy = $_POST["oldBrgy"];
            $brgyID = $_POST["brgyID"];
            $isNewBarangay = $_POST["isNewBarangay"];
            $arr_exist = array();
            
            if ($isNewBarangay == 1) {
                $find_barangay = mysqli_query($con,"SELECT * FROM es_barangay WHERE provinceID = $provinceID AND municipalityID = '$municipalityID' AND barangayName = '$barangay'");
               
                if (mysqli_num_rows($find_barangay) != 0) {
                    mysqli_next_result($con);
                    array_push($arr_exist,"Barangay");
                }
                
                if (count($arr_exist) == 0) {
                    $query = "INSERT INTO es_barangay (provinceID,municipalityID,barangayName,isActive,dateCreated) VALUES (?,?,?,?,?)";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sssss",$provinceID,$municipalityID,$barangay,$isActive,$global_date);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Barangay has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving barangay" . mysqli_error($con);
                    }
                } else {
                    $error   = true;
                    $color   = "orange";
                    $message = "Barangay already exist";
                }
            } else {
                if ($provinceID != $oldBrgyProvince || $municipalityID != $oldBrgyMunicipality || $barangay != $oldBrgy) {
                    $find_barangay = mysqli_query($con,"SELECT * FROM es_barangay WHERE provinceID = $provinceID AND municipalityID = '$municipalityID' AND barangayName = '$barangay'");
               
                    if (mysqli_num_rows($find_barangay) != 0) {
                        mysqli_next_result($con);
                        array_push($arr_exist,"Barangay");
                    }
                }
                
                if (count($arr_exist) == 0) {
                    $query = "UPDATE es_barangay SET provinceID=?,municipalityID=?,barangayName=?,isActive=? WHERE id=?";
                    if ($stmt = mysqli_prepare($con, $query)) {
                        mysqli_stmt_bind_param($stmt,"sssss",$provinceID,$municipalityID,$barangay,$isActive,$brgyID);
                        mysqli_stmt_execute($stmt);
                        
                        $error   = false;
                        $color   = "green";
                        $message = "Barangay has been save successfully"; 
                    } else {
                        $error   = true;
                        $color   = "red";
                        $message = "Error saving barangay" . mysqli_error($con);
                    }
                } else {
                    $error   = true;
                    $color   = "orange";
                    $message = "Barangay already exist";
                }
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