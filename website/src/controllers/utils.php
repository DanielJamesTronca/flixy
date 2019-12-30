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
}

?>