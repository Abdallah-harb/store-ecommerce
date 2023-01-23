<?php
//function to switch between lang
function get_folder(){

    return app()->getLocale() =='ar'? 'css-rtl':'css';
}

define('PAGINATION_COUNT',15);

//general function for upload images

function uploadImage($folder, $image){

    $image->store('/',$folder);
    $fileName  = $image->hashName();
    return $fileName;
}
