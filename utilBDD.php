<?php

    function connecterBDD($server, $user, $pass) {

        $DBconn = mysql_connect($server, $user, $pass);
        if (!$DBconn) {
            die("Erreur: mysql_connect");
        }

        return $DBconn;
    }

    function deconnecterBDD($DBconn) {
        if (isset($DBconn)) {
            mysql_close($DBconn);
        }
    }

    function transformerDate($dateS) {
        $aaaa = substr($dateS,0,4);
        $mm = substr($dateS,5,2);
        $mois = "";
        switch ($mm) {
            case "01" : 
                $mois = "janvier";
                break;
            case "02" : 
                $mois = "février";
                break;
            case "03" :
                $mois = "mars";
                break;
            case "04" : 
                $mois = "avril";
                break;
            case "05" :
                $mois = "mai";
                break;
            case "06" : 
                $mois = "juin";
                break;
            case "07" :
                $mois = "juillet";
                break;
            case "08" : 
                $mois = "août";
                break;
            case "09" :
                $mois = "septembre";
                break;
            case "10" : 
                $mois = "octobre";
                break;
            case "11" :
                $mois = "novembre";
                break;
            default : 
                $mois = "décembre";
                break;
        }
        $jj = substr($dateS,8);
        return ($jj." ".$mois." ".$aaaa);
    }
