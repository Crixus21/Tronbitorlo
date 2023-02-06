<?php 
include_once 'header.php'; 

    $commentPageNr = ceil(count($jatekMessages) / 10);

;?>
 
<!-- <script>
  var menuheight = document.getElementById("elsomenu");
  var magassag = menuheight.clientHeight + "px";
  var logoimg = document.getElementById("logoimg");
  logoimg.style.height = magassag;

</script> -->



    <div class="center-content jatekterem">
        <div id="jatekter">

          <div id="jatek-left">

            <img id="img-tronterem" src="Images/shira-yaari-01-reference.jpg" alt="Trónterem">
<?php
            if(loggedIn())
            {
?>
            <div class="chartable">
              <div class="mychar">
                  <img class="img-avatar" src="Images/Avatar/<?php echo $_SESSION['charimg']; ?>">
                <span class="charname"><?php echo $_SESSION['knev']; ?></span>
              </div>
              <form id="comment-form">
                <textarea id="comment-area" name="comment-area"> </textarea>
                
                <div id="comment-submit" class="gomb normal" onclick="sendComment()">Elküld</div>
                <div id="comment-refresh" class="gomb normal" onclick="refreshCommentList()">Frissítés</div>
              </form> 
                <p class="charstory"><?php echo $_SESSION['ktortenet']; ?></p>

            </div>
<?php
            }
?>
          </div>

        
            
            
        <div id="jatek-mid">
            <div class="comment-container">
            <h2>Jelenleg a Trónon:</h2>
            

            </div>
            <div class="pagination">
<?php
            for ($i = 0; $i < $commentPageNr; $i++) 
            {
?>
                <a <?php if($i === 0) { echo 'class="active"';} else {echo 'onclick="displayComments('. $i + 1 .')"';} ?>><?php echo $i + 1; ?></a>
                
<?php
            }
?>    
            </div>

        </div>
<?php
        $sql = "select infData from informacio where infid = 1";
        $result = mysqli_query($dbc, $sql);
        list($infData) = mysqli_fetch_row($result);
        
        $infData = explode('/', $infData);
        
        $sql = "select knev, charimg from userek where uid = " . $infData[0];
        $result = mysqli_query($dbc, $sql);
        list($wknev, $wcharimg) = mysqli_fetch_row($result);
        $wweeklyProgress = $infData[1];
        
        
        $progMinutes = floor($wweeklyProgress / 60);
        $progHours = floor($progMinutes / 60);
        $progDays = floor($progHours / 24);
    
        $progHours = $progHours - $progDays * 24;
        $progMinutes = $progMinutes - $progDays * 24 * 60 - $progHours * 60;
        $progSeconds = $wweeklyProgress - $progDays * 24 * 60 * 60 - $progHours * 60 * 60 - $progMinutes * 60;
        $progResult = array($progDays, $progHours, $progMinutes, $progSeconds);

        $wweeklyProgress = '';

            for($i = 0; $i < count($progResult); $i++)
            {
                switch($i) {
                    case 0:
                        $tempString = (integer)$progResult[$i] === 0 ? '' : abs($progResult[$i]) . ' n ';
                        $wweeklyProgress .= $tempString;
                        break;
                    case 1:
                        $tempString = (integer)$progResult[$i] === 0 ? '' : abs($progResult[$i]) . ' ó ';
                        $wweeklyProgress .= $tempString;
                        break;
                    case 2:
                        $tempString = (integer)$progResult[$i] === 0 ? '' : abs($progResult[$i]) . ' p ';
                        $wweeklyProgress .= $tempString;
                        break;
                    case 3:
                        $tempString = (integer)$progResult[$i] === 0 ? '' : abs($progResult[$i]) . ' mp';
                        $wweeklyProgress .= $tempString;
                        break;
                }
            }

?>
            
            
          <div id="jatek-right">
            <div class="winner">
            <h2>Múlt hét nyertese:</h2>
            <img class="img-avatar" src="Images/Avatar/<?php echo $wcharimg; ?>">
            <a class="knevLink" href="karakter.php?knev=<?php echo $wknev; ?>"><span class="charname"><?php echo $wknev; ?></span></a>
            <span class="chartime" id="winnertime"><?php echo $wweeklyProgress; ?></span>  
            </div>
              
        </div>
            


</div>



    </div>


  <!--<div class="right-content">
    <div class="rc-container">
      <p><?php //print(Date("l F d, Y")); ?></p>
      <fieldset>
        <legend>Bejelentkezés</legend>
        <form>
          
          <label for="fuser">Username:</label> <br />
          <input type="text" id="fuser" name="fuser"> <br />
          <label for="fpsw">Password:</label> <br />
          <input type="password" id="fpsw" name="fuser">  <br />
          <input type="submit" value="Belépés">
        </form>
      </fieldset>
      
      
    </div>
  </div> -->
</div>

<?php include_once 'footer.php'; ?>