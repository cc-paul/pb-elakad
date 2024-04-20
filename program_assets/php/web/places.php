<?php
    header('Content-Type: application/json');
    if(!isset($_SESSION)) { session_start(); } 
    include 'appkey_generator.php';
    include dirname(__FILE__,2) . '/config.php';
    include $main_location . '/connection/conn.php';
    include '../builder/builder_select.php';
    include '../builder/builder_table.php';

    $places  = array();
    $features = array();
    
    $sql  = "
        SELECT
            a.buildingName,
            a.latLong
        FROM
            el_map_masterfile a
        WHERE
            a.isActive = 1
    ";
    $result = mysqli_query($con,$sql);
    
    $json = array();
    while ($row  = mysqli_fetch_row($result)) {
        $latlong = explode(',', $row[1]);
        
        $features[] = array(
            'type'=> 'Feature',
            'properties'=> array(
                'description'=> $row[0],
                'icon'=> 'theatre'
            ),
            'geometry'=> array(
                'type'=> 'Point',
                'coordinates'=> [$latlong[1],$latlong[0]]
            )
        );
    }
    
    $places = array(
        'type' => 'FeatureCollection',
        'features' => $features
    );
    echo json_encode($places);
    
    mysqli_close($con);    
?>