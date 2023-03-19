<?php 
    function aktFajlnev () {
        return pathinfo(filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), PATHINFO_FILENAME);
    }

    function titkosit ($jelszo)
    {
        for ($i = 0; $i < 324; $i++) {
            $jelszo = hash('sha512',hash('sha512',$jelszo));
        }
        return $jelszo;
    }
    
    function loggedIn()
    {
        return isset($_SESSION['uid']);
    }
    
    function is_cli()
    {
        if ( defined('STDIN') )
        {
            return true;
        }

        if ( php_sapi_name() === 'cli' )
        {
            return true;
        }

        if ( array_key_exists('SHELL', $_ENV) ) {
            return true;
        }

        if ( empty($_SERVER['REMOTE_ADDR']) and !isset($_SERVER['HTTP_USER_AGENT']) and count($_SERVER['argv']) > 0) 
        {
            return true;
        } 

        if ( !array_key_exists('REQUEST_METHOD', $_SERVER) )
        {
            return true;
        }

        return false;
    }
    
    function reCaptcha($recaptcha){
        $secret = SECRETKEY;
        $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_SPECIAL_CHARS);
        $postvars = array("secret"=>$secret, "response"=>$recaptcha);
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data, true);
    }   
    
    function getJatekMessages ($dbc) {
        $jatekMessages = array();
        $sql = "select jmsgid, uid, charmsg, beginDate from jatekter";
        $result = mysqli_query($dbc, $sql);

        while(list($jmsgid, $uid, $charmsg, $beginDate) = mysqli_fetch_row($result))
        {
            $newRow = array('jmsgid' => $jmsgid, 'uid' => $uid, 'charmsg' => $charmsg, 'beginDate' => $beginDate);
            $jatekMessages[] = $newRow;
        }
        return $jatekMessages;
    }
    
    function getKocsmaMessages ($dbc) {
        $kocsmaMessages = array();
        $sql = "select kmsgid, uid, kocsmamsg, kocsmaDate from kocsma";
        $result = mysqli_query($dbc, $sql);

        while(list($kmsgid, $uid, $kocsmamsg, $kocsmaDate) = mysqli_fetch_row($result))
        {
                    $newRow = array('kmsgid' => $kmsgid, 'uid' => $uid, 'kocsmamsg' => $kocsmamsg, 'kocsmaDate' => $kocsmaDate);
            $kocsmaMessages[] = $newRow;
        }
        
        return $kocsmaMessages;
    }
    
    function createMessagesJSON ($dbc) {
            $jatekMessages = getJatekMessages($dbc);
            $returnMessageTable = array();
            
            foreach ($jatekMessages as $i => $jatekMessage)
            {
                $sql = "select knev, charimg from userek where uid =" . $jatekMessages[$i]['uid'];
                $result = mysqli_query($dbc, $sql);
                list($knev, $karakterkep) = mysqli_fetch_row($result);
                
                $tempComment = (object)['knev' => $knev, 'charimg' => $karakterkep, 'beginDate' => $jatekMessages[$i]['beginDate'], 'charmsg' => $jatekMessages[$i]['charmsg']];
                $returnMessageTable[] = $tempComment;
            }
            
            return json_encode($returnMessageTable);
        }
        
        function createKocsmaMessagesJSON ($dbc) {
            $kocsmaMessages = getKocsmaMessages($dbc);
            $returnKocsmaMessageTable = array();
            foreach ($kocsmaMessages as $i => $kocsmaMessage)
            {
                $sql = 'select knev from userek where uid =' . $kocsmaMessage['uid'];
                $result = mysqli_query($dbc, $sql);
                list($knev) = mysqli_fetch_row($result);
                
                $tempComment = (object)['knev' => $knev, 'kTime' => $kocsmaMessage['kocsmaDate'], 'kocsmamsg' => $kocsmaMessage['kocsmamsg']];
                $returnKocsmaMessageTable[] = $tempComment;
            }
            
            return json_encode($returnKocsmaMessageTable);
            
        }
        
        function randomChars()
        {
            $jelszo = '';
            for ($i = 1; $i < 100; $i++) {
                $jelszo .= KARAKTEREK[rand(0,mb_strlen(KARAKTEREK)-1)];
            }
            return $jelszo;
        }
        
        function emailFejlec()
        {
            return 'From:' .  ADMIN_EMAIL . PHP_EOL .
                   'Reply-To:' .  ADMIN_EMAIL  . PHP_EOL .
                   'Mime-Version: 1.0' . PHP_EOL .
                   'Content-type: text/html; charset=UTF-8' . PHP_EOL . 
                   'X-Priority: 1' . PHP_EOL .
                   'X-Mailer: ' . phpversion() . PHP_EOL   ;
        }
?>