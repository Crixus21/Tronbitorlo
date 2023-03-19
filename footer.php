</div>
<div class="footer">
  <div class="footer-license">
    <p>Minden jog fenntartva &copy;</p>
  </div>
  <div class="footer-links">
    <ul>
      <li><a href="faq.php">Miről szól a játék/FAQ</a></li>
      <li><a href="linkek.php">Linkek</a></li>
      <li><a href="impresszum.php">Impresszum</a></li>
    </ul>
  </div>
</div>
</body>

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
<script src="Ajax.js"></script>
<script>refreshCommentList('jatekter', '', 'tooEarly');</script>
<?php
    }
    if(aktFajlnev() === 'kocsma')
    {
?>
<script src="Ajax.js"></script>
<script src="kocsma.js"></script>
<?php
    }
?>
</html>
