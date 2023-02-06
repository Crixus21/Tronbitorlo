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
    
    function reCaptcha($recaptcha){
        $secret = SECRETKEY;
        $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_SPECIAL_CHARS);

        $postvars = array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
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
    


?>