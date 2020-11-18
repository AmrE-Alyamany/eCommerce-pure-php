<?php

	ob_start();
	session_start();
	$noNavbar = '';
	$pageTitle = 'Login';
	/*if (isset($_SESSION['Username'])) {
		header('Location: dashboard.php');
	}*/

	include 'init.php';

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$username = $_POST['user'];
			$password = $_POST['pass'];
			$hashedPass = sha1($password);
		//Check if user found in database ... 
			$stmt = $con->prepare("SELECT UserID , Username , Password FROM users WHERE Username = ? 
				AND Password = ? AND GroupID = 1 LIMIT 1");
			$stmt->execute(array($username, $hashedPass));
			$row = $stmt->fetch();
			$count = $stmt->rowCount();

			if ($count > 0) {
				$_SESSION['Username'] = $username; 
				$_SESSION['ID'] = $row['UserID'];
				header('Location: dashboard.php');
				exit();
			}
		}

?>
	<div class="body-login">
		<div class="gradient">
			<table>
				<tbody>
					<tr>
						<td>
							<div class="container">
								<div class="form">
									<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST">
										<span>Kofy Login</span><hr class="hr-login">
										<h5>Username <i class="fa fa-user"></i></h5>
										<input class="" data-wow-duration="2000ms" type="text" name="user" placeholder="User Name" required />
										<h5>Password <i class="fa fa-question"></i></h5>
										<input class="password" data-wow-duration="2000ms" type="password" name="pass" placeholder="Your Password" required />
										<input class="wow pulse animated" data-wow-iteration="infinite" data-wow-duration="1500ms" type="submit" value="Login"/>
									</form>
									<a href="#">Forgot password</a>
									<a href="#" style="float: right;">Sign up here</a>
									<div class="social text-center">
										<a href="#"><i class="fa fa-facebook"></i></a>
										<a href="#"><i class="fa fa-twitter"></i></a>
										<a href="#"><i class="fa fa-instagram"></i></a>
										<a href="#"><i class="fa fa-youtube"></i></a>
										<a href="#"><i class="fa fa-github"></i></a>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

<?php
	include $tpl . 'footer.php';
	ob_end_flush();
?>