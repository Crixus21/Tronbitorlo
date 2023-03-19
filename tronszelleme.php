<?php
    include_once 'control.php';

    
    $szovegek = array(  'Hahaha... visszatértem',
                        'Ugye nem gondoltad, hogy a trón örökre a tiéd lesz',
                        'Mi ez a szag?',
                        'Enyém a trón');
    
    $dbc->begin_transaction();
            
            $dbc->query('update jatekter set jmsgid = jmsgid + 1 order by jmsgid desc;');
            $dbc->query("insert into jatekter (jmsgid, uid, charmsg) values (1, 2, '" . $szovegek[rand(0, count($szovegek) - 1)] . "');");
            $dbc->query('delete from jatekter where jmsgid > 30;');
            
            $sql = "select beginDate from jatekter where jmsgid = 1";
            $result = mysqli_query($dbc, $sql);
            list($trononDate) = mysqli_fetch_row($result);
            $sql = "select uid, beginDate from jatekter where jmsgid = 2";
            $result = mysqli_query($dbc, $sql);
            list($secondUid, $secondDate) = mysqli_fetch_row($result);
            $trononDate = new DateTime($trononDate);
            if(isset($secondUid))
            {
                $secondDate = new DateTime($secondDate);
                $diff = $secondDate->diff($trononDate);
                $seconds = $diff->s;
                $minutes = $diff->i;
                $hours = $diff->h;
                $days = $diff->d;
                $plusProgress = $seconds + 60*$minutes + 60*60*$hours + 60*60*24*$days;
                $dbc->query("update userek set weeklyProgress = weeklyProgress + $plusProgress where uid = " . $secondUid);
            }
            
            $dbc->commit();



?>