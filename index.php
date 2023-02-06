<?php 
include_once 'header.php'; 

?>
 
<!-- <script>
  var menuheight = document.getElementById("elsomenu");
  var magassag = menuheight.clientHeight + "px";
  var logoimg = document.getElementById("logoimg");
  logoimg.style.height = magassag;

</script> -->




  <div class="center-content index">

  
    <article>
      <div class="cikkely">
      <img class="cikkelykep" src="random_02.jpg" alt="Random kép" />
        <h1>A cím</h1>
        <div class="author">Crixus, the Admin</div> <br>
        <time class="date">2022.10.04.</time>
<!--        <span id="uzenet"></span>-->
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium, reprehenderit aut. 
          Dolorum vel optio, voluptates quia quod sequi cumque illo itaque, incidunt eligendi enim doloremque cum, eveniet provident dolores ea.</p>
          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eligendi molestiae, a aliquid, architecto quam at vero nulla magnam illum, natus iure perferendis ullam suscipit pariatur quae. Quaerat minus in molestias?</p>
          <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium, reprehenderit aut. 
          Dolorum vel optio, voluptates quia quod sequi cumque illo itaque, incidunt eligendi enim doloremque cum, eveniet provident dolores ea.</p>
          <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium, reprehenderit aut. 
          Dolorum vel optio, voluptates quia quod sequi cumque illo itaque, incidunt eligendi enim doloremque cum, eveniet provident dolores ea.</p>
          <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium, reprehenderit aut. 
          Dolorum vel optio, voluptates quia quod sequi cumque illo itaque, incidunt eligendi enim doloremque cum, eveniet provident dolores ea.</p>
          <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium, reprehenderit aut. 
          Dolorum vel optio, voluptates quia quod sequi cumque illo itaque, incidunt eligendi enim doloremque cum, eveniet provident dolores ea.</p>
          <?php 
              echo "<p>Hello world</p>";
          ?>
        </div>
    </article>

  
    <article>
      <div class="cikkely"> 
      <img class="cikkelykep" src="random_01.jpg" alt="Random kép" />
        <h1>A cím2</h1>
        <div class="author">Crixus, the Admin</div>  <br>
        <time class="date">2022.10.04.</time>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium, reprehenderit aut. 
        Dolorum vel optio, voluptates quia quod sequi cumque illo itaque, incidunt eligendi enim doloremque cum, eveniet provident dolores ea.</p>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eligendi molestiae, a aliquid, architecto quam at vero nulla magnam illum, natus iure perferendis ullam suscipit pariatur quae. Quaerat minus in molestias?
        Eligendi molestiae, a aliquid, architecto quam at vero nulla magnam illum, natus iure perferendis ullam suscipit pariatur quae. Quaerat minus in molestias?</p>
        <?php 
            echo "<p>Hello world</p>";
        ?>
        </div>
        
    </article>
  


</div>


  <div class="right-content">
    <div class="rc-container">
      <p><?php print(Date("l, d F Y")); ?></p>
<?php
    if(!loggedIn())
    {
?>
      <fieldset>
        <legend>Bejelentkezés</legend>
        <form id="bejelentkezes" method="post" action="index.php">
          
          <label for="fuser">E-mail cím:</label> <br />
          <input type="text" id="fuser" name="inemail"> <br />
          <label for="fpsw">Jelszó:</label> <br />
          <input type="password" id="fpsw" name="inpassword"> <br />
          <input type="hidden" name="feladat" value="login">
          <input type="submit" name="belepes" value="Belépés"> <br>
          <a class="gomb regisztracio" href="regisztracio.php">Regisztráció</a>

        </form>
      </fieldset>
<?php
    }
?> 
      <h3>Első hír</h3>
      <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Inventore voluptates expedita quaerat rerum deleniti debitis sunt corrupti repudiandae, dolor dolore! Vel eaque veritatis debitis dicta autem repellat beatae illo expedita?</p>
      <h3>Második hír</h3>
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero eum quia fuga, repellat ipsa ipsum est, earum, vitae explicabo excepturi eos. Voluptates quis dolorum labore harum quo eveniet consequuntur libero?</p>
      
      


      
      <div class="yt-container">
      <iframe src="https://www.youtube.com/embed/J289ybY23D0">
      </iframe>
      </div>
    </div>
  </div>
</div>

<?php include_once 'footer.php'; ?>