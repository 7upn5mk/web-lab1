<?php

class Output
{
    private $x;
    private $y;
    private $r;
    private $executed_time;
    private $time;
    private $result;

    public function __construct($x,$y,$r){
        $this->x = (int) $x;
        $this->y = (double) $y;
        $this->r = (double) $r;
        $this->time = date("H:i:s");
        $start_time = microtime(true);
        $this->result = $this->verify()?"true":"false";
        $this->executed_time = number_format((float)(microtime(true) - $start_time)*pow(10,9),5,'.','');
    }

    public function verify() {
        $x=$this->x;
        $y=$this->y;
        $r=$this->r;
        if (($x>=0 and $y>=0 and $x<=$r and $y<=$r/2) or ($x<0 and $y>0 and $x+2-2*$y>=0) or ($x<0 and $y<0 and pow($x,2)+pow($y,2)<=pow($r,2))) {
            return true;
        } else return false;
    }

    public function get_x() {
        return $this->x;
    }
    public function get_y() {
        return $this->y;
    }
    public function get_r() {
        return $this->r;
    }
    public function get_time() {
        return $this->time;
    }
    public function get_executed_time() {
        return $this->executed_time;
    }
    public function get_result() {
        return $this->result;
    }
}