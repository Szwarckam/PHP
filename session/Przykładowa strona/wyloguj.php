<?php
session_start();
?>
<HTML>

<HEAD>
  <TITLE>Wylogowanie</TITLE>
</HEAD>

<BODY>
  <?php
  echo "Użytkownik " . $_SESSION["login"];
  echo " został wylogowany." . "<br>";
  echo "<A href='logowanie.php'>";
  echo "[Zaloguj się ponownie]</A>";
  session_destroy();
  ?>
</BODY>

</HTML>