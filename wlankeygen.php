<?php
$symbols=array('!', '"', '#', '$', '%', '&', '\'', '(', ')', '*', '+', ',', '-', '.', '/', ':', 
';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`', '{', '|', '}', '~');
$buchst=array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
foreach($buchst as $tmp){
    $symbols[] = $tmp;
}
foreach($buchst as $tmp){
    $symbols[] = strtoupper($tmp);
}
for($i = 0; $i <= 9; $i++){
    $symbols[] = $i;
}

function generateSymbol(){
    global $symbols;
    return $symbols[rand(0, count($symbols))];    
}

function generateSymbols($num = 63){
    $ret = '';
    for ($i = 1; $i <= $num ; $i++){
        $ret .= generateSymbol();
    }
    return $ret;
}

define('_title', 'Web Tools: WlanKeyGen - Der Wlan Schl&uuml;ssel Generator');
define('_keywords', 'WlanKeyGen, Wlan Key Generator, complex Passwort generator');

$ueberschrift = 'Web Tools: PWGen - Der Passwort Generator';
$bild_rechts = '<img src="##baseurl##Bilder/07.jpg">';
include('../includes/pw.func.php');
if (isset($_POST['submit']) && isset($_POST['anzahl'])){
    $_POST['anzahl'] = preg_replace('/([^0-9]*)/', '', $_POST['anzahl']);
    if ($_POST['anzahl'] >= 63){
        $_POST['anzahl'] = 63;
    }elseif($_POST['anzahl'] <= 0){
        $_POST['anzahl'] = 10;
    }
    $_POST['anzahl'] = $_POST['anzahl'] -0;
    if (is_int($_POST['anzahl'])){
        $content = '<font color="green">Erfolg</font>:<br />
        Ihr neuer, '.$_POST['anzahl'].'-stelliger Wlan Key wurde generiert:<br />'.
        '<textarea style="width:100%;">'.generateSymbols($_POST['anzahl']).'</textarea>';
    }else{
        $content = '<font color="red">Fehler</font>:<br />
        Die eingegebene Anzahl ist nicht numerisch.';
    }
    $content .= '<br /><br />';
}else{
    $_POST['anzahl'] = 63;
}


$content .= '
<form method="post">
Zeichen Anzahl:
<input name="anzahl" value="'.$_POST['anzahl'].'" />
<input name="submit" type="submit" value="Passwort generieren" />
</form>
<br /><br />
Dieser Wlan Key Generator erstellt f&uuml;r Sie WPA2 kompatible Key\'s mit bis zu 63 Zeichen.<br />
Verwendet werden also Buchstaben von a-z, A-Z, sowie Zahlen und erlaubte Sonderzeichen (Als Modell dienen die erlaubten Zeichen f&uuml;r die Fritz! Box).<br />
Sollte der ausgegebene Wlan Key Ihnen zu unsicher sein, k&ouml;nnen Sie durch einen Klick auf generieren einfach ein neues Passwort erstellen.<br />
<br />
<a href="http://www.webdesign-hoehne.de/tools/">Zur Web Tools &Uuml;bersicht</a>
';

echo $content;
