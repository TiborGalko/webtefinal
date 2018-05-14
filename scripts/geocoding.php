<?php
//funkcia vrati latlng zo zadanej adresy
function getLatLngFromAddr($addr) {
    $addr = rawurlencode($addr);
    $urltopost = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDpnArBmSGhkTmYTQRXiDZMi9h6xj1LwHA&address=SK,'.$addr;
    $ch = curl_init($urltopost);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    return json_decode($json);
}