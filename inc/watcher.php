<?php
function is_user_auth () {
    if(isset($_SESSION['user'])) {
       return true;
    } 
    else {
       return false;
    }
}
