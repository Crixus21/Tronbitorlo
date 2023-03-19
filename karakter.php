<?php
    include_once 'header.php';
    
    if(isset($ginKnev))
    {
    $sql = "select knev, ktortenet, charimg, weeklyProgress from userek where knev = '$ginKnev'";
    $result = mysqli_query($dbc, $sql);
    list($charknev, $charktortenet, $charcharimg, $weeklyProgress) = mysqli_fetch_row($result);
    
    $progMinutes = floor($weeklyProgress / 60);
    $progHours = floor($progMinutes / 60);
    $progDays = floor($progHours / 24);
    
    $progHours = $progHours - $progDays * 24;
    $progMinutes = $progMinutes - $progDays * 24 * 60 - $progHours * 60;
    $progSeconds = $weeklyProgress - $progDays * 24 * 60 * 60 - $progHours * 60 * 60 - $progMinutes * 60;
    $progResult = array($progDays, $progHours, $progMinutes, $progSeconds);
    
    $weeklyProgress = '';
        
        for($i = 0; $i < count($progResult); $i++)
        {
            switch($i) {
                case 0:
                    $tempString = (integer)$progResult[$i] === 0 ? '' : abs($progResult[$i]) . ' n ';
                    $weeklyProgress .= $tempString;
                    break;
                case 1:
                    $tempString = (integer)$progResult[$i] === 0 ? '' : abs($progResult[$i]) . ' ó ';
                    $weeklyProgress .= $tempString;
                    break;
                case 2:
                    $tempString = (integer)$progResult[$i] === 0 ? '' : abs($progResult[$i]) . ' p ';
                    $weeklyProgress .= $tempString;
                    break;
                case 3:
                    $tempString = (integer)$progResult[$i] === 0 ? '' : abs($progResult[$i]) . ' mp';
                    $weeklyProgress .= $tempString;
                    break;
            }
        }
            
    if(isset($charknev))
    {
?>
<div class="center-content jatekterem">
    <article class="karakter">
        <div class="cikkely karakter">
            <div class="chartable karakter">
              <div class="mychar">
                  <h2>Karakterlap</h2>
                  <img class="img-avatar" src="images/Avatar/<?php echo $charcharimg; ?>">
                <span class="charname"><?php echo $charknev?></span>
              </div>
                <h4 class="weeklyprogress">Játékban eltöltött idő ezen a héten:</h4>
                <p class="weeklyprogress"><span class="chartime"><?php echo $weeklyProgress; ?></span></p>
<?php
                if(!empty($charktortenet))
                {
?>  
                <h4 style="margin:1rem 0 0;">Karaktertörténet:</h4>
              
                <p class="charstory"><?php echo $charktortenet?></p>
<?php
                }
                    if(loggedIn() && $charknev === $_SESSION['knev'])
            {
?>
                <input type="submit" form="charChange" name="charChange" value="Módosítás">
                <form id="charChange" style="display:none;" method="post" action="karaktermod.php">
                    <input type="hidden" name="feladat" value="charchange">
                </form>
                
<?php
            }
?>
            </div>
        </div>
    </article>
</div>
<?php
        }
    }
    include_once 'footer.php';
?>

