<?php
class Circle{
    public $radius;

    public function calculateArea(){
        // formular Area = πr2
        if(!is_numeric($this->radius) || $this->radius <= 0){
            return -1;
        }

        return pow($this->radius, 2) * M_PI;
    }
}
?>
