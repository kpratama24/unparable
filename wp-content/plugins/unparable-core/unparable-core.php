<?php
/**
 * Plugin Name: Unparable Core
 * Plugin URI: http://unpar.ac.id
 * Version: 1.0
 * Author: Kevin Pratama
 * Author URI: https://nearkevin.cu.cc/
 * Description: Everything UNPARABLE needs
 */
function updateProfile()
{
	global $wpdb;
	$redirect = "http://localhost/unparable";
	if (!isset($_POST['profile_name'])&&!isset($_POST['profile_student_status'])) {
		echo "There is no input";
	}
	else{
	$tablename = "tbmhs";
	$results= $wpdb->insert($tablename,array(
		'NPM' => $_POST['profile_student_number'],
		'NIM' => time(),
		'NAMA' => $_POST['profile_name'],
		'JENISKELAMIN' => $_POST['profile_gender'],
		'ALAMAT' => $_POST['profile_address'],
		'AGAMA' => $_POST['profile_religion'],
		'KOTALAHIR' => $_POST['profile_origin'],
		'TANGGALLAHIR' => $_POST['profile_birth'],
		'PONSEL' => $_POST['profile_phone_number'],
		'EMAIL' => $_POST['profile_email'],
		'STATUSMHS' => $_POST['profile_student_status'],
		'TANGGALUPDATE' => date("Y-m-d")
	));
	if ($results>0) {
		echo "Profile berhasil diupdate ! Anda akan diarahkan beberapa saat lagi";
		wp_redirect($redirect);
		exit;
	}
	else if($results === false){
		echo "Update gagal. Silahkan update kembali profil anda !";
	}
	}
	
}

function showProfileDetails()
{
	global $wpdb;
	$tablename = $tbmhs;
	$npm = "2013730073";
	$results = $wpdb->get_row('SELECT * FROM tbmhs WHERE npm=\''.$npm.'\'');
	return "<";
}

function login()
{
	global $wpdb;
	$username="";
	$password="";
	$tablename="tbmhs_users";
	if (isset($_POST['username'])&&isset($_POST['password'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$wpdb->show_errors();
		$results = $wpdb->get_row('SELECT * FROM tbmhs_users WHERE username=\''.$username.'\'');
		$hash = $results->password;
		if (password_verify($_POST['password'],$hash)) {
			if (is_numeric(substr($_POST['username'], 0,1))) {
			return "Login Berhasil ! Anda login sebagai Mahasiswa. <a href=\"http://localhost/unparable/dashboard\">Masuk ke dashboard</a><br><br>";
			}
		else return "Login Berhasil ! Anda login sebagai Staff UNPAR. <a href=\"http://localhost/unparable/dashboard\">Masuk ke dashboard</a><br><br>";
		}
		else if ($hash=="") {
			?>
		<form action="<?php echo echoSiteURL(); ?>/masuk" method="POST">
			<input type="text" name="username" placeholder="Username / NPM" required><br><br>
			<input type="password" name="password" placeholder="Password" required><br><br>
			<input type="hidden" name="hash" placeholder="testHash">
			<input type="submit" value="Login">
		</form>
		<?php
			return "Username belum terdaftar ! <br><br>";
		}
		else{
			?>
		<form action="<?php echo echoSiteURL(); ?>/masuk" method="POST">
			<input type="text" name="username" placeholder="Username / NPM" required><br><br>
			<input type="password" name="password" placeholder="Password" required><br><br>
			<input type="hidden" name="hash" placeholder="testHash">
			<input type="submit" value="Login">
		</form>
		<?php
			return "Password yang anda masukkan salah. Silahkan coba lagi ! <br><br>";
		}
	}
	else{
		?>
		<form action="<?php echo echoSiteURL(); ?>/masuk" method="POST">
			<input type="text" name="username" placeholder="Username / NPM" required><br><br>
			<input type="password" name="password" placeholder="Password" required><br><br>
			<input type="hidden" name="hash" placeholder="testHash">
			<input type="submit" value="Login">
		</form>
		<?php
	}
}

function hashPassword()
{
	global $wpdb;
	$tablename =  "tbmhs_users";
	if (isset($_POST['hash'])) {
		$username = $_POST['username'];
		$hashedPassword = password_hash($_POST['hash'],PASSWORD_DEFAULT);
		$wpdb->show_errors();
		$results = $wpdb->insert($tablename,array(
			'username' => $username,
			'password' => $hashedPassword
		));
	}
	?>
		<form action="<?php echo echoSiteURL(); ?>/masuk" method="POST">
			<input type="text" name="username" placeholder="Username" required><br><br>
			<input type="password" name="hash" placeholder="Password" required><br><br>
			<input type="submit" value="Create">
		</form>
		<?php
}

function submitAchievements()
{
	global $wpdb;
	$redirect = "http://localhost/unparable";
	if (!isset($_POST['achievement_name'])&&!isset($_POST['achievement_grade'])) {
		echo "There is no input";
	}
	else{
	$tablename = "tbmhs_prestasi";
	$wpdb->show_errors();
	$results= $wpdb->insert($tablename,array(
		'NPM' => $_POST['achievement_student_number'],
		'PRESTASI' => $_POST['achievement_name'],
		'DESKRIPSIPRESTASI' => $_POST['achievement_description'],
		'SERTIFIKAT' => '',
		'BOBOTPRESTASI' => $_POST['achievement_grade']
	));
	if ($results>0) {
		echo "Prestasi berhasil disubmit ! Anda akan diarahkan beberapa saat lagi";
		wp_redirect($redirect);
		exit;
	}
	else if($results === false){
		echo "Submit gagal. Silahkan submit kembali prestasi anda!";
	}
	}
}

function checkSession()
{
	if (!isset($_SESSION['username'])) {
		echo "Anda belum login. Silahkan login terlebih dahulu";
	}
	else if (isset($_SESSION['username'])) {
		$username = substr($_SESSION['username'], 0,1);
		if(is_numeric($username)){
			return;
		}
		else{
			return;
		}
	}
}

function displayEmail()
{
	return $_SESSION['CASUser'];
}

function displayName()
{
	return "Selamat datang ".$_SESSION['CASUser']."! <a href='./dashboard'>Masuk ke Dashboard</a>";
}

function echoSiteURL()
{
	return site_url();
}
add_shortcode('name','displayName');
add_shortcode('email','displayEmail');
add_shortcode('hash','hashPassword');
add_shortcode('profile','showProfileDetails');
add_shortcode('siteurl','echoSiteURL');
add_shortcode('masuk','login');
add_shortcode('updateProfile','updateProfile');
add_shortcode('submitAchievements','submitAchievements');
?>