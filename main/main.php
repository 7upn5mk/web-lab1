<?php
require_once("Output.php");
require_once('JSON.php');
$json = new Services_JSON();
session_start();
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    try {
        $x_range = array(-4,-3,-2,-1,0,1,2,3,4);
        $r_range = array(1,1.5,2,2.5,3);
        if (!isset($_POST["x"]) or !isset($_POST["y"]) or !isset($_POST["r"])) {
            throw new Exception("Data have been sent unsuccessfully");
        } else if ((!is_numeric($_POST["x"])) or (!is_numeric($_POST["y"])) or (!is_numeric($_POST["r"]))) {
            throw new Exception("Wrong formatted data");
        } else if (!in_array($_POST["x"],$x_range) or $_POST["y"]<-3 or $_POST["y"]>5 or !in_array($_POST["r"],$r_range)) {
            throw new Exception("Numbers are not in required ranges");
        } else {
            $coord = new Output($_POST["x"],$_POST["y"],$_POST["r"]);
            $results = (isset($_SESSION["results"]))?($_SESSION["results"]):array();
            array_push($results,$coord);
            $_SESSION["results"] = $results;
            echo $json->encode(array("x"=>$coord->get_x(),"y"=>$coord->get_y(),"r"=>$coord->get_r(),"result"=>$coord->get_result(),"time"=>$coord->get_time(),"executed_time"=>$coord->get_executed_time()));
        }
    } catch (Exception $e) {
        echo $json->encode(array("error"=>$e->getMessage()));
    }
} else {
    echo $json->encode(array("error"=>($_SERVER["REQUEST_METHOD"].' request method is not allowed')));
}
