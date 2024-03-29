<?php
if (version_compare(PHP_VERSION, '4.1.0', '<')) {
    // $_POST Super Global abwärtskompabilität
    if (isset($HTTP_POST_VARS['submit']) && isset($HTTP_POST_VARS['anzahl'])) {
        $_POST['submit'] = $HTTP_POST_VARS['submit'];
        $_POST['anzahl'] = $HTTP_POST_VARS['anzahl'];
    }
}
if (version_compare(PHP_VERSION, '4.2.0', '<')) {
    // besserer Zufallsgenerator, wenn PHP Version kleiner 4.2
    srand((double) microtime() * 1000000);
}
$symbols = array('!', '"', '#', '$', '%', '&', '\'', '(', ')', '*', '+', ',', '-', '.', '/', ':',
    ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`', '{', '|', '}', '~');
$buchst  = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
foreach ($buchst as $tmp) {
    $symbols[] = $tmp;
}
foreach ($buchst as $tmp) {
    $symbols[] = strtoupper($tmp);
}
unset($buchst);
for ($i = 0; $i <= 9; $i++) {
    $symbols[] = $i;
}
define("SYMBOLS", $symbols);
unset($symbols);
define("SYMBOLS_COUNT", count(SYMBOLS));

function generateSymbol() {
    return SYMBOLS[rand(0, SYMBOLS_COUNT - 1)];
}

function generateSymbols($num = 63) {
    $ret = '';
    for ($i = 1; $i <= $num; $i++) {
        $ret .= generateSymbol();
    }
    return $ret;
}

if (isset($_POST['anzahl']) && (is_string($_POST['anzahl']) || is_integer($_POST['anzahl']))) {
    $_POST['anzahl'] = intval(preg_replace('/([^0-9]*)/', '', $_POST['anzahl']));
    if ($_POST['anzahl'] >= 63) {
        $_POST['anzahl'] = 63;
    } elseif ($_POST['anzahl'] <= 0) {
        $_POST['anzahl'] = 10;
    }
    $content = '<font color="green">Erfolg</font>:<br />' .
        'Ihr neuer, ' . $_POST['anzahl'] . '-stelliger Wlan Key wurde generiert:<br />' .
        '<textarea style="width:100%;">' . generateSymbols($_POST['anzahl']) . '</textarea>' .
        '<br /><br />';
} else {
    $_POST['anzahl'] = 63;
    $content         = '';
}

$content .= '
<form method="post">
Zeichen Anzahl:
<input name="anzahl" value="' . $_POST['anzahl'] . '" />
<input name="submit" type="submit" value="Passwort generieren" />
</form>
<br /><br />
Dieser Wlan Key Generator erstellt WPA2/WPA3 kompatible Key\'s mit bis zu 63 Zeichen.<br />
Verwendet werden also Buchstaben von a-z, A-Z, sowie Zahlen und erlaubte Sonderzeichen (Als Modell dienen die erlaubten Zeichen f&uuml;r die Fritz! Box).<br />
Sollte der ausgegebene Wlan Key Ihnen zu unsicher sein, k&ouml;nnen Sie durch einen Klick auf generieren einfach ein neues Passwort erstellen.';

echo $content;
