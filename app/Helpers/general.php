<?php
//function to switch between lang
function get_folder(){

    return app()->getLocale() =='ar'? 'css-rtl':'css';
}

define('PAGINATION_COUNT',100);
