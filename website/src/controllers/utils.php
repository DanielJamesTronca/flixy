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
        return date_format($dateTime,"Y");
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

    // funzioni per layout.php e home.php
    public static function research($input) {
        if ($input) {
          if (SessionManager::isUserLogged()) {
            return Media::list(SessionManager::getUserId(), $input, null, null, 2, null, "ASC");
          } else {
            return Media::list(null, $input, null, null, 2, null, "ASC");
          }
        }
    }

    public static function generateMovieGenreOptions($genreList) {
        $list = [];
        for ($x = 0; $x < count($genreList); $x++) { 
            $genre = $genreList[$x]->name;
            if (isset($_GET["genre-select"])) {
                if ($_GET["genre-select"] == $genre) {
                $element = "<option selected value='".$genre."'>".$genre."</option>";
                } else {
                $element = "<option value='".$genre."'>".$genre."</option>";
                }
            } else {
                $element = "<option value='".$genre."'>".$genre."</option>";
            }
            array_push($list, $element);
        }
        return implode($list);
    }

    public static function generateMovieYearOptions($yearList) {
        $list = [];
        for ($x = 0; $x < count($yearList); $x++) { 
            $year = $yearList[$x]->anno;
            if (isset($_GET["year-select"])) {
                if ($_GET["year-select"] == $year) {
                $element = "<option selected value=".$year.">".$year."</option>";
                } else {
                $element = "<option value='".$year."'>".$year."</option>";
                }  
            } else {
                $element = "<option value='".$year."'>".$year."</option>";
            }
            array_push($list, $element);
        }
        return implode($list);
    }

    public static function generateMovieTypeOptions() {
        $type1 = "Film";
        $type2 = "Serie";
        if (isset($_GET["type-select"])) {
          if ($_GET["type-select"] == $type1) {
            $element = "<option selected value='".$type1."'>".$type1."</option>"."<option value='".$type2."'>".$type2."</option>";
          } 
          if ($_GET["type-select"] == $type2) {
            $element = "<option value='".$type1."'>".$type1."</option>"."<option selected value='".$type2."'>".$type2."</option>";
          }  
          if ($_GET["type-select"] == "All") {
            $element = "<option value='".$type1."'>".$type1."</option>"."<option value='".$type2."'>".$type2."</option>";
          }
        } else {
          $element = "<option value='".$type1."'>".$type1."</option>"."<option value='".$type2."'>".$type2."</option>";
        }
    
        return $element;
    }

    public static function getFilteredMovieList($year, $genre, $type, $userId = null) {
        if ($genre != "All") {
            $genreId = Genre::getIdGenre($genre)[0]->id;
        }
        switch ($type) {
            case "Film":
                $typeId = 0;
            break;
            case "Serie":
                $typeId = 1;
            break;
        }
        return Media::list($userId, null, ($year != "All" ? $year : null), ($genre != "All" ? $genreId : null), ($type != "All" ? $typeId : 2), null, "ASC");
    }

    public static function checkLikedMovies($id) {
        $votedMovies = null;
        if (SessionManager::isUserLogged()) {
            $userId = SessionManager::getUserId();
            $votedMovies = Media::getUserVotes($userId);
        }   
        if ($votedMovies != null) {
            for ($x = 0; $x < count($votedMovies); $x++) {
                if ($votedMovies[$x]->media_id == $id) {
                    switch ($votedMovies[$x]->positive) {
                        case 1:
                            return 1;
                        break;
                        case 0:
                            return 0;
                        break;
                    }
                }
            }
            return -1;
        } else {
            return -1;
        }
    }

    public static function replaceContentsMovieCard($card, $title, $coverUrl, $stars, $id, $votesTotal, $votesPositive, $isFav) {
        $starNumber = [];
        if ($votesPositive == null) {
          $card = str_replace("{likes}", 0, $card);
        } else {
          $card = str_replace("{likes}", $votesPositive, $card);
        }
        $movie = Media::fetch($id);
        if ($movie->hasEpisodes == 1) {
          $card = str_replace("{isMovie}", "Serie", $card);
        } else {
          $card = str_replace("{isMovie}", "Film", $card);
        }
        $card = str_replace("{movieTitle}", $title, $card);
        $card = str_replace("{mediaNotFav}", !($isFav == true) ? "" : "hidden", $card);
        $card = str_replace("{mediaIsFav}", ($isFav == true) ? "" : "hidden", $card);
        $card = str_replace("{dislikes}", $votesTotal-$votesPositive, $card);
        $card = str_replace("{coverURL}", "../public/".$coverUrl, $card);
        $card = str_replace("{movieID}", $id, $card);
        $card = str_replace("{linkDettaglioMovie}", "./php/layout.php?page=dettaglio&amp;movieId=".$id, $card);
        $check = Utils::checkLikedMovies($id);
        switch($check) {
            case 1:
                $card = str_replace("{like-selected}", "thumb-selected", $card);
            break;
            case 0:
                $card = str_replace("{dislike-selected}", "thumb-selected", $card);
            break;
            case -1: {
                $card = str_replace("{like-selected}", " ", $card);
                $card = str_replace("{dislike-selected}", " ", $card);
            } break;
        }
        for($i=0;$i<$stars;$i++) {
            array_push($starNumber, "<i class='fa fa-star'></i>");
        }
        $card = str_replace("{starNumber}", $stars, $card);
        $card = str_replace("{movieStars}", implode($starNumber), $card);
        return $card;
    }

    public static function generateMovieList($list) {
        $movieList = [];
        if (!is_array($list)) {
          $list = [];
        }
        for ($x = 0; $x < count($list); $x++) {
          $card = Utils::replaceContentsMovieCard(file_get_contents("../html/movie-card.html"), $list[$x]->title, $list[$x]->coverUrl, $list[$x]->stars, $list[$x]->id, $list[$x]->votesTotal, $list[$x]->votesPositive, $list[$x]->isFavourite);
          array_push($movieList, $card);
        }
        return implode($movieList);
    }
}
?>