<?php

    session_start();

include_once 'functions.php';
include_once 'const.php';

    //adatbázis kapcsolat

    $dbc = mysqli_connect('localhost', 'root', '', 'tronbitorlo');
    mysqli_query($dbc, 'set names utf8');

    
    //form beolvasás
    
    $charname = filter_input(INPUT_POST, 'charname', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_SPECIAL_CHARS);
    $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_SPECIAL_CHARS);
    $passwordOld = filter_input(INPUT_POST, 'passwordOld', FILTER_SANITIZE_SPECIAL_CHARS);
    $regCharstory = filter_input(INPUT_POST, 'charstory', FILTER_SANITIZE_SPECIAL_CHARS);
    $charImg = filter_input(INPUT_POST, 'charimg', FILTER_SANITIZE_SPECIAL_CHARS);
    $feladat = filter_input(INPUT_POST, 'feladat', FILTER_SANITIZE_SPECIAL_CHARS);
    $gfeladat = filter_input(INPUT_GET, 'feladat', FILTER_SANITIZE_SPECIAL_CHARS);
    $getUzenet = filter_input(INPUT_GET, 'uzenet', FILTER_SANITIZE_SPECIAL_CHARS);
    $inEmail = filter_input(INPUT_POST, 'inemail', FILTER_SANITIZE_SPECIAL_CHARS);
    $inPassword = filter_input(INPUT_POST, 'inpassword', FILTER_SANITIZE_SPECIAL_CHARS);
    $ginKnev = filter_input(INPUT_GET, 'knev', FILTER_SANITIZE_SPECIAL_CHARS);
    $recaptcha = filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data))
    {
        if(isset($data['uid']) && isset($data['comment']))
        {
            $puid = filter_var($data['uid'], FILTER_SANITIZE_SPECIAL_CHARS);
            $pcomment = filter_var($data['comment'], FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        $feladat = filter_var($data['feladat'], FILTER_SANITIZE_SPECIAL_CHARS);
    }
    
    $uzenet = '';
    $hibauzenet = '';
    
    
    switch($getUzenet) {
    case 'regsuccess' :
        $uzenet .= 'Regisztráció sikeres.<br>';
        break;
    case 'modsuccess' :
        $uzenet .= 'Adatok módosítása sikeres.<br>';
        break;
    }
    
    $fajlok = scandir(getcwd() . '/images/avatar');
    array_shift($fajlok);
    array_shift($fajlok);
    $fajlok = array_values($fajlok);
    
    
    //Hétváltás
    
    $sql = "select infData from informacio where infid = 2";
    $result = mysqli_query($dbc, $sql);
    list($lastWeekChange) = mysqli_fetch_row($result);
    $lastWeekChange = new DateTime($lastWeekChange);
    $diff = (new DateTime())->getTimestamp() - $lastWeekChange->getTimestamp();
    
    
    if(($diff / 60 / 60 / 24) > 7)
    {
        
        $dbc->begin_transaction();
        
        $sql = "select uid, weeklyProgress from userek where weeklyProgress = (select max(weeklyProgress) from userek)";
        $result = mysqli_query($dbc, $sql);
        list($maxUid, $maxProgress) = mysqli_fetch_row($result);
        
        $newProgress = (string)$maxUid . "/" . (string)$maxProgress;
        $dbc->query("update informacio set infData = '$newProgress' where infid = 1");
        $dbc->query("update userek set weeklyProgress = 0");
        $refreshDate = new DateTime();
        $refreshDate = $refreshDate->format("Y-m-d H:i:s");
        $dbc->query("update informacio set infData = '$refreshDate' where infid = 2");
        
        $dbc->commit();
    }
    
    
    //Eseménykezelés
    
    if($feladat === 'regisztracio')
    {
        $sql = "select count(*) from userek where email = '$email'";
        $result = mysqli_query($dbc, $sql);
        list($talaltUser) = mysqli_fetch_row($result);
        settype($talaltUser, 'integer');
        
        if(empty(trim($charname)))
        {
            $hibauzenet .= 'Hiba! A karakternevet ki kell töltsd!<br>';
        }
        if(empty(trim($email)))
        {
            $hibauzenet .= 'Hiba! E-mail mező üres.<br>';
        }
        if(mb_strlen($charname) > 40)
        {
            $hibauzenet .= 'Hiba! A karakterneved túl hosszú.<br>';
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $hibauzenet .= 'Hiba! E-mail formátum nem megfelelő.<br>';
        }
        if($password1 !== $password2)
        {
            $hibauzenet .= 'Hiba! A két jelszó nem azonos.<br>';
        } 
        if ($talaltUser > 0) 
        {
            $hibauzenet .= 'Hiba! Ezzel az email címmel már regisztráltak.<br>';
        }
        $sql = "select count(*) from userek where knev = '$charname'";
        $result = mysqli_query($dbc, $sql);
        list($userDarab) = mysqli_fetch_row($result);
        if((integer)$userDarab > 0)
        {
            $hibauzenet .= 'Hiba! A karakternév foglalt.';
        }
        
        $res = reCaptcha($recaptcha);
        if(!$res['success']){
            $hibauzenet .= 'A recaptcha-t pipálni kell!';
        }
        
        if(empty($hibauzenet))
        {
            $sql = "insert into userek (knev, email, jelszo, ktortenet, charimg) values ('$charname','$email','".titkosit($password1)."','$regCharstory', '$charImg')";
            if(mysqli_query($dbc, $sql))
            {
                header("Location: index.php?uzenet=regsuccess");
                exit();
            }
        }
    }
    
    if($feladat === 'login')
    {
        $sql = "select uid, knev, email, ktortenet, charimg from userek where email = '$inEmail' and jelszo = '".titkosit($inPassword)."'";
        $result = mysqli_query($dbc, $sql);
        list($_SESSION['uid'],$_SESSION['knev'], $_SESSION['email'], $_SESSION['ktortenet'], $_SESSION['charimg']) = mysqli_fetch_row($result);
        
        if(loggedIn())
        {
            $uzenet .= 'Sikeres belépés.';
        }
        
    }
    
    if($feladat === 'modositas')
    {
        if($email !== $_SESSION['email'])
        {
            $sql = "select count(*) from userek where email = '$email'";
            $result = mysqli_query($dbc, $sql);
            list($talaltUser) = mysqli_fetch_row($result);
            settype($talaltUser, 'integer');
            if ($talaltUser > 0) 
            {
                $hibauzenet .= 'Hiba! Ezzel az email címmel már regisztráltak.<br>';
            }
        }
        if(empty(trim($charname)))
        {
            $hibauzenet .= 'Hiba! A karakternevet ki kell töltsd!<br>';
        }
        if(empty(trim($email)))
        {
            $hibauzenet .= 'Hiba! E-mail mező üres.<br>';
        }
        if(mb_strlen($charname) > 40)
        {
            $hibauzenet .= 'Hiba! A karakterneved túl hosszú.<br>';
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $hibauzenet .= 'Hiba! E-mail formátum nem megfelelő.<br>';
        }
        if($password1 !== $password2)
        {
            $hibauzenet .= 'Hiba! A két új jelszó nem azonos.<br>';
        } 
        
        if($charname !== $_SESSION['knev'])
        {
            $sql = "select count(*) from userek where knev = '$charname'";
            $result = mysqli_query($dbc, $sql);
            list($userDarab) = mysqli_fetch_row($result);
            if((integer)$userDarab > 0)
            {
                $hibauzenet .= 'Hiba! A karakternév foglalt.';
            }
        }
        $sql = "select uid from userek where uid = '".$_SESSION['uid']."' and jelszo = '".titkosit($passwordOld)."'";
        $result = mysqli_query($dbc, $sql);
        list($talaltUser) = mysqli_fetch_row($result);
        if(!isset($talaltUser))
        {
            $hibauzenet .= 'Hiba! Nem megfelelő jelszó.';
        }
        
        if(empty($hibauzenet))
        {
            $sqlKieg = (!empty($password1)) ? ", jelszo = '".titkosit($password1)."'" : '';
            
            $sql = "update userek set knev = '$charname', email = '$email', ktortenet = '$regCharstory', charimg = '$charImg'" . $sqlKieg . "where uid = " . $_SESSION['uid'];
            mysqli_query($dbc, $sql);
            
            $_SESSION['knev'] = $charname;
            $_SESSION['email'] = $email;
            $_SESSION['ktortenet'] = $regCharstory;
            $_SESSION['charimg'] = $charImg;
            
            header("Location: index.php?uzenet=modsuccess");
            exit();
        }
        
        
    }
    
    //SQL táblák
    
    $jatekMessages = getJatekMessages($dbc);
    
    //Ajax kezelés
    if ($feladat === 'sendComment')
    {
       
        if((string)$puid === $_SESSION['uid'] && !empty(trim($pcomment)))
        {
            $dbc->begin_transaction();
            
            $dbc->query('update jatekter set jmsgid = jmsgid + 1 order by jmsgid desc;');
            $dbc->query("insert into jatekter (jmsgid, uid, charmsg) values (1, $puid, '$pcomment');");
            $dbc->query('delete from jatekter where jmsgid > 30;');
            
            $sql = "select beginDate from jatekter where jmsgid = 1";
            $result = mysqli_query($dbc, $sql);
            list($trononDate) = mysqli_fetch_row($result);
            $sql = "select uid, beginDate from jatekter where jmsgid = 2";
            $result = mysqli_query($dbc, $sql);
            list($secondUid, $secondDate) = mysqli_fetch_row($result);
            $trononDate = new DateTime($trononDate);
            $secondDate = new DateTime($secondDate);
            $diff = $secondDate->diff($trononDate);
            $seconds = $diff->s;
            $minutes = $diff->i;
            $hours = $diff->h;
            $days = $diff->d;
            $plusProgress = $seconds + 60*$minutes + 60*60*$hours + 60*60*24*$days;
            $dbc->query("update userek set weeklyProgress = weeklyProgress + $plusProgress where uid = " . $secondUid);
            
            $dbc->commit();
            
            
            
            echo createMessagesJSON($dbc);
        }
        
            
            
    }
    
    if($feladat === 'getCommentList')
    {
        echo createMessagesJSON($dbc);
    }
    
    
    if($gfeladat === 'logout')
    {
        unset($_SESSION['uid']);
        unset($_SESSION['knev']);
        unset($_SESSION['email']);
        unset($_SESSION['ktortenet']);
        unset($_SESSION['charimg']);
        
        $uzenet .= 'Kijelentkezés sikeres.';
    }

?>

