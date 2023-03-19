        <?php

        
       include_once 'control.php';
        
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