<?php

/*
Библиотека полезных функций ocStore
http://myopencart.ru
http://opencartforum.ru
ocStore © 2012
ocTeam Dinox, afwollis

*/

class ocStore {
    private $config;
    private $db;
    private $data = array();

    public function validate($string = "", $filter = "2") {
        $filters["1"] = FILTER_VALIDATE_INT;
        $filters["2"] = FILTER_VALIDATE_EMAIL;
        $filters["3"] = FILTER_VALIDATE_URL;
        $filters["0"] = FILTER_VALIDATE_BOOLEAN;

        $res = filter_var($string, $filters["" . $filter . ""]);

        return ($res);
    }

    public function return_bytes($val) {
        $val = trim($val);
        switch (strtolower(substr($val, -1))) {
            case 'm':
                $val = (int)substr($val, 0, -1) * 1048576;
                break;
            case 'k':
                $val = (int)substr($val, 0, -1) * 1024;
                break;
            case 'g':
                $val = (int)substr($val, 0, -1) * 1073741824;
                break;
            case 'b':
                switch (strtolower(substr($val, -2, 1))) {
                    case 'm':
                        $val = (int)substr($val, 0, -2) * 1048576;
                        break;
                    case 'k':
                        $val = (int)substr($val, 0, -2) * 1024;
                        break;
                    case 'g':
                        $val = (int)substr($val, 0, -2) * 1073741824;
                        break;
                    default :
                        break;
                }
                break;
            default:
                break;
        }

        return $val;
    }

    public function getUploadMaxFileSizeBytes() {
        $uploadMaxFileSize = ini_get('upload_max_filesize');

        return empty($uploadMaxFileSize) ? 300000 : $this->return_bytes($uploadMaxFileSize);
    }
}