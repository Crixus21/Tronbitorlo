<?php 
include_once 'header.php';

    $charchange = $feladat === 'charchange' || $feladat === 'modositas'  ? true : false;
    $cim = $charchange ? 'Karakter módosítás' : 'Regisztráció'; 
    $gombFelirat = $charchange ? 'Módosítás' : 'Regisztrálok'; 
    
            if(loggedIn() && isset($feladat) || !loggedIn() && !isset($feladat) || !loggedIn() && $feladat === 'regisztracio')
    {
    
    ?>
    

    <div class="center-content regisztracio">
        <article>
            <div class="cikkely">
                <form id="regisztracioForm" name="regisztracio" method="post">
                    <h2><?php echo $cim; ?></h2>
                    <div id="regHibaUzenet" <?php if(!empty($hibauzenet)) { echo 'style="display:block;"'; }?>>
                        <p><?php if(!empty($hibauzenet)) {echo $hibauzenet;} ?></p>
                    </div>
                    <label for="charname">Karakter neved:</label> <br>
                    <input type="text" name="charname" <?php if($charchange){echo 'value="'. $_SESSION['knev'].'"';}?> required> <br>
                    <label for="email">E-mail cím: </label> <br>
                    <input type="email" name="email" autocomplete="off" <?php if($charchange){echo 'value="'. $_SESSION['email'].'"';}?> required> <br>
<?php 
                    if ($charchange)
                    {
?>
                    <label for="password1">Jelszó: </label> <br>
                    <input type="password" name="passwordOld" autocomplete="off" required> <br>
<?php
                    }
?>
                    <label for="password1"><?php if($charchange) {echo 'Új jelszó: ';} else { echo 'Jelszó: ';}?> </label> <br>
                    <input type="password" name="password1" autocomplete="off" <?php if(!$charchange) { echo 'required'; }?>> <br>
                    <label for="password2"><?php if($charchange) {echo 'Új jelszó mégegyszer: ';} else { echo 'Jelszó mégegyszer: ';}?></label> <br>
                    <input type="password" name="password2" autocomplete="off" <?php if(!$charchange) { echo 'required'; }?>> <br>
                    <label for="charstory">Karaktered története (nem kötelező):</label> <br>
                    <textarea id="regCharStory" name="charstory"><?php if($charchange){echo $_SESSION['ktortenet'];}?></textarea>
                    <label>Karakterképed:</label><br>
                    <img id="regCharImg" src="images/avatar/<?php if($charchange){echo $_SESSION['charimg'].'"';} else {echo '01.jpg';}?>" alt="Karakterkep"> <br>
<?php
                    if(!$charchange)
                    {
?>
                    <div class="g-recaptcha brochure__form__captcha" data-sitekey="<?php echo SITEKEY; ?>"></div>
<?php
                    }
?>
                    <input type="hidden" name="feladat" value="<?php if($charchange) { echo 'modositas'; } else { echo 'regisztracio'; }?>">
                    <input type="submit" name="elkuld" value="<?php echo $gombFelirat; ?>">
                </form>
                <div id="charImgSelect">
                <h3>Válassz karakterképet:</h3>
                <div id="radioContainer">
                    
<?php
                foreach ($fajlok as $i => $fajl) {
                    

?>
                    <input id="radio<?php echo $i; ?>" type="radio" name="charimg" value="<?php echo $fajl; ?>" form="regisztracioForm" <?php if($i === 0 && !isset($feladat) && !loggedIn() || loggedIn() && $charchange && $fajl === $_SESSION['charimg']) { echo 'checked';} ?>>
                    <label for="radio<?php echo $i; ?>"><img src="images/avatar/<?php echo $fajl?>" alt="Karakter kep"></label>
                    
<?php
}
?>                    
                </div>
                </div>
                </div>
        </article>
        
    </div>
    
    
</div>
<?php 
    }
    
include_once 'footer.php';
?>