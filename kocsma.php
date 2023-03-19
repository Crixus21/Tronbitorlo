<?php 
include_once 'header.php';
?>

<div class="center-content kocsma">
    <div class="kocsma-container">
        <img src="images/layout/Kocsma1.jpg" alt="kocsma" id="kocsmaImg1">
        <img src="images/layout/Kocsma2.jpg" alt="kocsma" id="kocsmaImg2">
        <div id="wrapper">
            <h2>Kocsma<?php if(loggedIn()) {echo ' - ' . $_SESSION['knev']; }?></h2>
            <div id="chatbox">
            </div>
<?php       if(loggedIn())
            {
?> 
            <form id="kocsmaForm" name="kocsma" action="">
            <input type="text" id="kocsmaComment" autocomplete="off">

            <div class="gomb" onclick="sendComment('kocsma')">Elküld</div>
<?php
            }
?>
        </form>
        </div>
    </div>
</div>
<?php 
include_once 'footer.php';
?>