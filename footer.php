</div>
<div class="footer">
  <div class="footer-license">
    <p>Minden jog fenntartva &copy;</p>
  </div>
  <div class="footer-links">
    <ul>
      <li><a href="" target="_parent">Miről szól a játék/FAQ</a></li>
      <li><a href="" target="_parent">Linkek</a></li>
      <li><a href="" target="_parent">Contact</a></li>
      
    </ul>
  </div>
</div>
<!--    <script>
        
        document.addEventListener('readystatechange', event => { 

    // When window loaded ( external resources are loaded too- `css`,`src`, etc...) 
    if (event.target.readyState === "complete") {
    var logo = document.getElementById('logoimg');
    var logow = logo.clientWidth;
    let uzenet = document.getElementById('uzenet');
    uzenet.innerHTML = logow + ' a szélesség';
    }
    });
        
    
</script>  -->
</body>

<?php 
    if(loggedIn())
    {
?>
<script>
var selfuid = <?php echo $_SESSION['uid']; ?>;
</script>
<?php
    }
?>
<script src="scripts.js"></script>
<?php
    if(aktFajlnev() === 'regisztracio')
    {
?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php
    }
?>

<?php
    if(aktFajlnev() === 'jatekterem')
    {
?>

<script src="Ajax_jatekterem.js"></script>

<script>
    refreshCommentList();
</script>
<?php
    }
?>
</html>
