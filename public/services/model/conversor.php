<?php
    function converterDataFromISO($dataISO) {
        if($dataISO != null) {
            $date = DateTime::createFromFormat('Y-m-d', $dataISO);
            return $date->format('d/m/Y');
        } else {
            return null;
        }
        
    }

    function converterDataToISO($data) {
        if ($data != null) {
            $date = DateTime::createFromFormat('d/m/Y', $data);
            return $date->format('Y-m-d');
        } else {
            return null;
        }
        
    }
?>