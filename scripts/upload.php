<?php
include_once "../db/usersdb.php";

if(isset($_POST['submit'])) {
    parseCsv($_FILES['file']['tmp_name'], $_POST['delim'], $_POST['riadok']);
}

//prevzate z https://secure.php.net/manual/en/function.mb-convert-encoding.php
//funkcia na prevod win1250 na utf-8
function w1250_to_utf8($text) {
    // map based on:
    // http://konfiguracja.c0.pl/iso02vscp1250en.html
    // http://konfiguracja.c0.pl/webpl/index_en.html#examp
    // http://www.htmlentities.com/html/entities/
    $map = array(
        chr(0x8A) => chr(0xA9),
        chr(0x8C) => chr(0xA6),
        chr(0x8D) => chr(0xAB),
        chr(0x8E) => chr(0xAE),
        chr(0x8F) => chr(0xAC),
        chr(0x9C) => chr(0xB6),
        chr(0x9D) => chr(0xBB),
        chr(0xA1) => chr(0xB7),
        chr(0xA5) => chr(0xA1),
        chr(0xBC) => chr(0xA5),
        chr(0x9F) => chr(0xBC),
        chr(0xB9) => chr(0xB1),
        chr(0x9A) => chr(0xB9),
        chr(0xBE) => chr(0xB5),
        chr(0x9E) => chr(0xBE),
        chr(0x80) => '&euro;',
        chr(0x82) => '&sbquo;',
        chr(0x84) => '&bdquo;',
        chr(0x85) => '&hellip;',
        chr(0x86) => '&dagger;',
        chr(0x87) => '&Dagger;',
        chr(0x89) => '&permil;',
        chr(0x8B) => '&lsaquo;',
        chr(0x91) => '&lsquo;',
        chr(0x92) => '&rsquo;',
        chr(0x93) => '&ldquo;',
        chr(0x94) => '&rdquo;',
        chr(0x95) => '&bull;',
        chr(0x96) => '&ndash;',
        chr(0x97) => '&mdash;',
        chr(0x99) => '&trade;',
        chr(0x9B) => '&rsquo;',
        chr(0xA6) => '&brvbar;',
        chr(0xA9) => '&copy;',
        chr(0xAB) => '&laquo;',
        chr(0xAE) => '&reg;',
        chr(0xB1) => '&plusmn;',
        chr(0xB5) => '&micro;',
        chr(0xB6) => '&para;',
        chr(0xB7) => '&middot;',
        chr(0xBB) => '&raquo;',
    );
    return html_entity_decode(mb_convert_encoding(strtr($text, $map), 'UTF-8', 'ISO-8859-2'), ENT_QUOTES, 'UTF-8');
}

//rozdelenie uploadnuteho csv
function parseCsv($file, $delim, $riadok) {
    if (($handle = fopen($file, "r")) !== FALSE) {
        $row = 1;
        while (($data = fgetcsv($handle, 1000, $delim)) !== FALSE) {
            if($row < $riadok) {
                $row++;
                continue;
            }

            $num = count($data);
            $user = array();
            $school = array();
            for ($c = 0; $c < $num; $c++) {
                $d = str_replace (array("\r\n", "\n", "\r", "\n\r"), ' ', w1250_to_utf8($data[$c]));
                $d = str_replace("'", '', $d);
                $d = trim($d);
                switch ($c) {
                    case 0: $user['id'] = $d; break;
                    case 1: $user['surname'] = $d; break;
                    case 2: $user['name'] = $d; break;
                    case 3: $user['email'] = $d; break;
                    case 4: $school['name'] = $d; break;
                    case 5: $school['addr'] = $d; break;
                    case 6: $user['street'] = $d; break;
                    case 7: $user['psc'] = $d; break;
                    case 8: $user['city'] = $d; break;
                }
            }
            insertNewUser($user['surname'],$user['name'],$user['email'],
                $school['name'],$school['addr'],$user['street'],$user['psc'],$user['city'],"user123"); //default
        }
        fclose($handle);
    }
}



?>