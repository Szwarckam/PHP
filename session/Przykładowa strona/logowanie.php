<?php
$mysqli = @new mysqli("127.0.0.1", "root", null, "kszwarc");
$error = "";
if (isset($_POST['login'], $_POST['pass'])) {
	$login = $_POST['login'];
	$userpassword = sha1($_POST['pass']);
	$result = $mysqli->query("SELECT userlogin, userpassword FROM users WHERE (userlogin='$login') and (userpassword='$userpassword')");
	$row = $result->fetch_assoc();
	if ($row) {
		$userlogin = $row['userlogin'];
		echo "Git";
		session_start();
		$_SESSION['login'] = $_POST['login'];
		header("Location: glowna.php");
		exit();
	} else {
		$error = "<B>Błędne dane logowania!</B><BR>";
	}
} else
	$error = false;
?>
<HTML>

<HEAD>
	<TITLE>Logowanie</TITLE>
</HEAD>

<BODY>
	<?php
	echo $error ? $error : "";
	?>
	<B>Podaj login i&nbsp;hasło</B>
	<FORM method="POST">
		Login: <INPUT type="text" name="login"><BR>
		Hasło: <INPUT type="password" name="pass"><BR>
		<INPUT type="submit" value="Zaloguj się">
	</FORM>
</BODY>

</HTML>