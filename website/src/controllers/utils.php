<?php

class Utils {
    public static function is_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function randomString($length) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
    
        for ($i = 0; $i < $length; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
    
        return $randomString; 
    }

    public static function uploadImage($target_dir, $imageReq, $prepath = "") {
        $target_file = $target_dir . Utils::randomString(10);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($imageReq["name"],PATHINFO_EXTENSION));
        $target_file .= "." . $imageFileType;
        $check = getimagesize($imageReq["tmp_name"]);
        if($check !== false) {
           $uploadOk = 1;
        } else {
            return ["success" => false, "error" => "Error, file is not an image."];
            $uploadOk = 0;
        }

        if ($imageReq["size"] > 5000000) {
            return ["success" => false, "error" => "Error, your file is too large."];
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            return ["success" => false, "error" => "Error, only JPG, JPEG, PNG files are allowed."];
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            return ["success" => false, "error" => "Error, your file was not uploaded."];
        } else {
            if (move_uploaded_file($imageReq["tmp_name"], $prepath.$target_file)) {
                return ["success" => true, "url" => $target_file];
            } else {
                return ["success" => false, "error" => "Sorry, there was an error uploading your file."];
            }
        }
    }

    public static function convert_url_to_embed($url){
        $search = '#(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch?.*?v=))([\w\-]{10,12}).*#x';
        $replace = 'https://www.youtube.com/embed/$2';
        return preg_replace($search,$replace,$url);
    }

    public static function isValidUrl($url){
        $regex = '#(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch?.*?v=))([\w\-]{10,12}).*#x';
        if(!preg_match($regex,$url))
            return false;
        else
            return true;
    }

    public static function generateOptionsDay(){
        return
        "<option value='1'>1</option>
        <option value='2'>2</option>
        <option value='3'>3</option>
        <option value='4'>4</option>
        <option value='5'>5</option>
        <option value='6'>6</option>
        <option value='7'>7</option>
        <option value='8'>8</option>
        <option value='9'>9</option>
        <option value='10'>10</option>
        <option value='11'>11</option>
        <option value='12'>12</option>
        <option value='13'>13</option>
        <option value='14'>14</option>
        <option value='15'>15</option>
        <option value='16'>16</option>
        <option value='17'>17</option>
        <option value='18'>18</option>
        <option value='19'>19</option>
        <option value='20'>20</option>
        <option value='21'>21</option>
        <option value='22'>22</option>
        <option value='23'>23</option>
        <option value='24'>24</option>
        <option value='25'>25</option>
        <option value='26'>26</option>
        <option value='27'>27</option>
        <option value='28'>28</option>
        <option value='29'>29</option>
        <option value='30'>30</option>
        <option value='31'>31</option>";
    }

    public static function generateOptionsMonth(){
        return
        "<option value='1'>Gennaio</option>
        <option value='2'>Febbraio</option>
        <option value='3'>Marzo</option>
        <option value='4'>Aprile</option>
        <option value='5'>Maggio</option>
        <option value='6'>Giugno</option>
        <option value='7'>Luglio</option>
        <option value='8'>Agosto</option>
        <option value='9'>Settembre</option>
        <option value='10'>Ottobre</option>
        <option value='11'>Novembre</option>
        <option value='12'>Dicembre</option>";
    }

    public static function generateOptionsYear(){
        return
        "<option value='2019'>2019</option>
        <option value='2020'>2020</option>
        <option value='2021'>2021</option>
        <option value='2022'>2022</option>
        <option value='2023'>2023</option>
        <option value='2024'>2024</option>
        <option value='2025'>2025</option>";
    }

    public static function restoreOptionsYear($yearToRestore){
        $options = "";
        $toRestore = "";
        for ($i=2019; $i<=2025; $i++){
            if ($i == $yearToRestore)
                    $toRestore = "<option value='$i'>$i</option><optgroup class='secondary-bg' label='--------'>";
            else
                $options .= "<option value='$i'>$i</option>";
        }
        $toRestore .= $options;
        $toRestore .= "</optgroup>";
        return $toRestore;
    }

    public static function getMonthNameFromNumber($monthNumber){
        $mesi = array(1=>'Gennaio', 'Febbraio', 'Marzo', 'Aprile',
        'Maggio', 'Giugno', 'Luglio', 'Agosto',
        'Settembre', 'Ottobre', 'Novembre','Dicembre');
        return $mesi[$monthNumber];
    }


    public static function restoreOptionsMonth($monthToRestore){
        $options = "";
        $toRestore = "";
        for ($i=1; $i<=12; $i++){
            $monthName = Utils::getMonthNameFromNumber($i);
            if ($i == $monthToRestore)
                $toRestore = "<option value='$i'>$monthName</option><optgroup class='secondary-bg' label='--------'>";
            else
                $options .= "<option value='$i'>$monthName</option>";
        }
        $toRestore .= $options;
        $toRestore .= "</optgroup>";
        return $toRestore;
    }

    public static function restoreOptionsDay($dayToRestore){
        $options = "";
        $toRestore = "";
        for ($i=1; $i<=31; $i++){
            if ($i == $dayToRestore)
                $toRestore = "<option value='$i'>$i</option><optgroup class='secondary-bg' label='--------'>";
            else
                $options .= "<option value='$i'>$i</option>";
        }
        $toRestore .= $options;
        $toRestore .= "</optgroup>";
        return $toRestore;
    }

    
    public static function getDayFromData($date){
        $dateTime = new DateTime($date);
        return date_format($dateTime,"d");
    }

    public static function getMonthFromData($date){
        $dateTime = new DateTime($date);
        return date_format($dateTime,"m");
    }

    public static function getYearFromData($date){
        $dateTime = new DateTime($date);
        return date_format($dateTime,"y");
    }

    public static function isValidDate($day,$month,$year){
        if (checkdate($month,$day,$year))
            return true;
        else
            return false;
    }

    public static function createDate($day,$month,$year){
        return $year."-".$month."-".$day." 00:00:00";
    }

    public static function unsetAll($variablesToUnset){
        foreach ($variablesToUnset as $var){
            unset($_SESSION[$var]);
        }
    }

}


?>