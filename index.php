<?php 
include_once 'header.php'; 
?>
  <div class="center-content index">
    <article>
      <div class="cikkely">
      <img class="cikkelykep" src="images/layout/random_02.jpg" alt="Kocka" />
        <h1>Az oldalról</h1>
        <div class="author">Crixus</div> <br>
        <time class="date">2023.02.24.</time>
            <p>
                Mint azt látjátok, egy régi oldal került feltámasztásra. Webfejlesztői tanulmányaim miatt szerettem volna egy egyszerűbb oldalt létrehozni, ahol a különböző technológiákat tudom gyakorolni. Majdhogynem 20 évvel ezelőtt, mikor a biti még fénykorát élte, bizony eltöltöttem pár estét előtte a trónteremben társalogva kisiskolásként. Időnként ránéztem azóta az lfg.hu-ra és tudomásom szerint már jó néhány éve nem létezik az oldal. Így kis vérfrissítéssel egy hasonló játékteret csináltam.
            </p>
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
      <h3>Képfeltöltés</h3>
      <p>Egyelőre képfeltöltés nem lehetséges az oldalon. Folyamatos moderálást igényelne, a későbbiek során ez is beépítésre kerülhet.</p>
      <h3>Indulunk</h3>
      <p>Elindult az új Trónbitorló oldal. Használjátok egészséggel.</p>
      <h3>Vicces videó</h3>
      <div class="yt-container">
      <iframe src="https://www.youtube.com/embed/J289ybY23D0">
      </iframe>
      </div>
    </div>
  </div>
</div>

<?php include_once 'footer.php'; ?>