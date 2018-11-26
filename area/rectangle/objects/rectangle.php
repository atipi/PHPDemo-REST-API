<?php
/**
 *
 * @author Porntip Chaibamrung <pchaibamrung@gmail.com>
 *
 */

/**
 * Calculate Rectangle area
 */
class Rectangle{
    public $height_value;
    public $width_value;

    public function calculateArea(){
        // formular Area = length * width
        if(!is_numeric($this->height_value) || $this->height_value < 0){
            return -1;
        }

        if(!is_numeric($this->width_value) || $this->width_value < 0){
            return -1;
        }

        $area_value = $this->height_value * $this->width_value;

        return $area_value;
    }
}
?>
