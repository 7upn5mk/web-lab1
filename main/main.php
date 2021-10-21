<?php
require_once("Output.php");
require_once('JSON.php');
$json = new Services_JSON();
session_start();
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    try {
        if (!isset($_POST["x"]) or !isset($_POST["y"]) or !isset($_POST["r"]) or (!is_numeric($_POST["x"])) or (!is_numeric($_POST["y"])) or (!is_numeric($_POST["r"]))) {
            throw new Exception("Data have been sent unsuccessfully");
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
