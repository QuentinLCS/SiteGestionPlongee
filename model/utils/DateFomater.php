<?php
    function dateFormater($date) {
        $dates = explode("-",$date);
        $res = $dates[1];
        switch($dates[1]) {
            case '01':
                $res = 'Janvier';
                break;
            case '02':
                $res = 'Février';
                break;
            case '03':
                $res = 'Mars';
                break;
            case '04':
                $res = 'Avril';
                break;
            case '05':
                $res = 'Mai';
                break;
            case '06':
                $res = 'Juin';
                break;
            case '07':
                $res = 'Juillet';
                break;
            case '08':
                $res = 'Août';
                break;
            case '09':
                $res = 'Septembre';
                break;
            case '10':
                $res = 'Octobre';
                break;
            case '11':
                $res = 'Novembre';
                break;
            case '12':
                $res = 'Décembre';
                break;
        }
        return $dates[2]." ".$res." ".$dates[0];
    }