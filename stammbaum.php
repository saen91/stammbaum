<?php
define('IN_MYBB', 1);
//define('NO_ONLINE', 1); // Wenn Seite nicht in Wer ist online-Liste auftauchen soll
define('THIS_SCRIPT', 'stammbaum.php');
 
//Mit global.php haben wir Zugriff auf eine Vielzahl von mybb-Funktionen und -Variablen
require_once './global.php';

global $templates, $db, $mybb, $page;

 
add_breadcrumb('Familienstammbäume', "familytree.php");

$all_trees = $db->query ("SELECT *
FROM ".TABLE_PREFIX."users u
LEFT JOIN ".TABLE_PREFIX."userfields uf
ON (u.uid = uf.ufid)
WHERE fid56 !=''
ORDER BY username ASC
");

while ($trees = $db->fetch_array($all_trees)){

    $username = format_name($trees['username'], $trees['usergroup'], $trees['displaygroup']);
    $user = build_profile_link($username, $trees['uid']);

    $tree_link = $trees['fid56'];
    $userid = $trees['uid'];

    eval('$familytree .= "' .$templates->get('familytrees_bit') . '";');
}

// Hier wird das erstellte Template geladen
eval('$page = "'.$templates->get('familytrees').'";'); 


//Spucken Sie die Seite an den Benutzer aus, sobald wir alle Vorlagen und Variablen zusammengestellt haben
output_page($page);
