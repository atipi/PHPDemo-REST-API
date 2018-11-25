<?php
class Square{
    public $length_value;

    public function calculateArea(){
        // formular Area = a2
        if(!is_numeric($this->length_value) || $this->length_value < 0){
            return -1;
        }

        return pow($this->length_value, 2);
    }
}
?>
