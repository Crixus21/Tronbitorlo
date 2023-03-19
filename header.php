<?php
include_once 'control.php';

?>
<!DOCTYPE html>
<html lang="hu">
<head>
 <link rel="stylesheet" href="mystyle.css">
<?php 
            switch(aktFajlnev()){
            case 'jatekterem' :
                ?><link rel="stylesheet" href="jatekterem.css"><?php
                break;
            case 'karakter' :
                ?><link rel="stylesheet" href="jatekterem.css"><?php
                break;
            case 'kocsma' :
                ?><link rel="stylesheet" href="kocsma.css"><?php
                break;
            }
?>
 <meta charset="utf-8">
 <title>Trónbitorló<?php if(isset($pageNames[aktFajlnev()])) {echo ' - ' . $pageNames[aktFajlnev()]; } ?></title>
<base href="#" target="_parent">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="favicon.ico" />
</head>

<body>
 <ul class="menusor" id="menusor">
    <li class="logo"><a href="index.php"><img id="logoimg" src="images\Crown.jpg" alt="Logo"></a></li>
    <li id="bitijel"><a href="index.php"><h2>Trónbitorló</h2></a></li>
    <input class="side-menu" type="checkbox" id="side-menu">
    <label class="menu-btn" for="side-menu"><div class="btn-container"><span class="menu-btn-line"></div></span></label>
    <div class="menupontok">
      <li><a href="index.php">Hírek</a></li>
      <li><a href="jatekterem.php">Játékterem</a></li>
      <li><a href="kocsma.php">Kocsma</a></li>
      <li><a href="phpBB3">Fórum</a></li>
    </div>
 </ul>
    <div id="teszt"></div>
    
<?php
        if(!empty($uzenet))
        {
?>
    <div class="alert"><div class="alert-uzenet"><?php echo $uzenet; ?> </div><span class="close-alert" onclick="hideParent(this)"></span></div>
<?php
        }
?>

    <div class="main-content">
    <div class="charlink">
<?php 
        if(loggedIn())
        {
?>
    <img class="img-avatar" src="images/avatar/<?php echo $_SESSION['charimg'];?>">
    <span class="mycharname"><a href="karakter.php?knev=<?php echo $_SESSION['knev']?>"><?php echo $_SESSION['knev'];?></a></span>
    <span style="color:white;"> &#x2022; </span>
    <span class="exitbtn"><a class="exitLink" href="index.php?feladat=logout"><svg id="exitSvg" onmouseover="changeSvgIn()" onmouseout="changeSvgOut()" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
  </svg></a><div class="tooltip">Kilépés</div></span>
    
<?php
        } else
        {
?>
    <span class="anonym"><a href="regisztracio.php">Anonymus</a></span>
<?php
        }
?>
    </div>