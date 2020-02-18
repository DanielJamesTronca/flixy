<?php
if (isset($_GET["search"])) {
    $varSearch = $_GET["search"];
    $varReturnSearch = Utils::research($varSearch);
} else {
    $varSearch = '';
    $varReturnSearch = '';
}

header("Location: ".SessionManager::BASE_URL."home");
?>