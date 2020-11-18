<?php

										/*==========================
									  	******  Members Page  ******
										==========================*/
	
	ob_start();
	session_start();
	$pageTitle = 'Members';
	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {

			$query = '';

			if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
				$query = 'AND RegStatus = 0';
			}

			$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
			$stmt->execute();
			$rows = $stmt->fetchAll();


			?>
			<h1 class="text-center wow pulse animated" data-wow-iteration="infinite" data-wow-duration="1500ms">Manage Member</h1>
			<div class="container" style="overflow: hidden;">
				<div class="table-responsive wow fadeInDown">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Username</td>
							<td>E-mail</td>
							<td>FullName</td>
							<td>Registerd Date</td>
							<td>Control</td>
						</tr>
						<?php
							foreach ($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['UserID'] . "</td>";
									echo "<td>" . $row['Username'] . "</td>";
									echo "<td>" . $row['Email'] . "</td>";
									echo "<td>" . $row['FullName'] . "</td>";
									echo "<td>" . $row['RDate'] ."</td>";
									echo "<td> 
												<a class='btn btn-success' href='members.php?do=Edit&userid="
												. $row['UserID'] ."' title='تعديل'><i class='fa fa-edit'></i></a>
												<a class='btn btn-danger confirm' href='members.php?do=Delete&userid="
												. $row['UserID'] ."' title='حذف'><i class='fa fa-close'></i></a>";
										if ($row['RegStatus'] == 0) {
										
											echo "<a class='btn btn-info active' href='members.php?do=Activate&userid="
												. $row['UserID'] ."' title='تفعيل'><i class='fa fa-check'></i>Active</a>";
										}
									echo "</td>";
								echo "</tr>";
							}
						?>
					</table>
				</div>
				<a class="btn btn-primary wow bounceInRight" data-wow-duration="2s" href='members.php?do=Add'><i class="fa fa-plus"></i> Add New Member </a>
			</div>

	<?php	
			} elseif ($do == 'Add') { ?>

			<h1 class="text-center wow pulse animated" data-wow-iteration="infinite" data-wow-duration="1500ms">Add New Member</h1>

				<div class="container" style="overflow: hidden;">
					<form class="form-horizontel" action="?do=Insert" method="POST">

						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration=".5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> UserName </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="username" class="form-control" 
								autocomplete="" required="required" placeholder="Don't be less than 3 CHAR">	
							</div>
						</div>

						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="1s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Password </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="password" name="password" class="password form-control" autocomplete=""
								required="required" placeholder="Must be hard">
								<i class="show-pass fa fa-eye"></i>
							</div>
						</div>

						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration="1.5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Email </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="email" name="email" class="form-control" 
								required="required" placeholder="Must be valid">	
							</div>
						</div>

						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="2s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Full Name </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="fullname" class="form-control" 
								required="required" placeholder="Name your Profile">
							</div>
						</div>

						<div class="form-group wow bounceInUp" data-wow-duration="3s">
							<div class="col-sm-offset-4 col-sm-8">
								<input type="submit" value="Add Member" class="btn btn-danger btn-lg">	
							</div>
						</div>

					</form>
				</div>
			
	<?php	

			/*====================== Insert Page ========================*/

			} elseif ($do == "Insert") {

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Insert Members</h1>";
					echo "<div class='container'>";

					$username 	= $_POST['username'];
					$password 	= $_POST['password'];
					$email 		= $_POST['email'];
					$fullname 	= $_POST['fullname'];
					$hashpass   = sha1($_POST['password']);
					
					//Validate the Form

					$formErrors = array();

					if (empty($username) || empty($email) || empty($fullname) || empty($password)) {
						$formErrors[] = "You must full all empties!";
					} if (strlen($username) < 3) {
						$formErrors[] = "Username can't be less than <strong>3 CHAR</strong>";
						//LOOP ento Errors array and echo it
					} foreach ($formErrors as $errors) {
						echo "<div class='alert alert-danger'>" . $errors . "</div>";
					}

					if (empty($formErrors)) {
						
						$check = checkItem('Username', 'users', $username);

						if ($check > 0) {

							$theMsg = '<div class="alert alert-danger">This User Is Exist!</div>';
							redirectHome($theMsg, 5);

						} else {
							// Insert on Database
							$stmt = $con->prepare("INSERT INTO users(Username , Password , Email , FullName , RegStatus , RDate) 
								VALUES(:user , :pass , :email , :full , 1 , now())");

							$stmt -> execute(array(
								'user' => $username,
								'pass' => $hashpass,
								'email'=> $email,
								'full' => $fullname
							));
							
							echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated </div>';

						}
					} 
				} else {
						$errorMsg = "SORRY! You can not Browse this page ..";
						redirectHome($errorMsg , 4);
					}

			} elseif ($do == 'Edit') {

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

			$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?  LIMIT 1");
			$stmt->execute(array($userid));
			$row = $stmt->fetch();
			$count = $stmt->rowCount();

			if ($count > 0) {
?>

				<h1 class="text-center wow pulse animated" data-wow-iteration='infinite' data-wow-duration='1500ms'>Edit Member</h1>

				<div class="container">
					<form class="form-horizontel" action="?do=Update" method="POST">

						<input type="hidden" name="userid" value="<?php echo $userid ?>">

						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration=".5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> UserName </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="username" class="form-control" 
								value="<?php echo $row['Username']; ?>" autocomplete="off" required="required">	
							</div>
						</div>

						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="1s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Password </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>">
								<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="If you don't want change password, leave the blank">
							</div>
						</div>

						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration="1.5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Email </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="email" name="email" class="form-control" 
								value="<?php echo $row['Email']; ?>" required="required">	
							</div>
						</div>

						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="2s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Full Name </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="fullname" class="form-control" 
								value="<?php echo $row['FullName']; ?>" required="required">	
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8 wow bounceInUp" data-wow-duration="3s">
								<input type="submit" value="Save" class="btn btn-primary btn-lg">	
							</div>
						</div>

					</form>
				</div>

<?php  
		} else {
			 $errorMsg = "There is NO SUCH ID!!";

			redirectHome($errorMsg);
		}
		//Update Page Codeing...

	} elseif ($do == 'Update') {
		
		echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Update Members</h1>";
		echo "<div class='container'>";

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$id 		= $_POST['userid'];
			$username 	= $_POST['username'];
			$email 		= $_POST['email'];
			$fullname 	= $_POST['fullname'];
			//Password Trick...

			$pass = empty($_POST['newpassword']) ? $pass = $_POST['oldpassword'] : $pass = sha1($_POST['newpassword']);
			
			//Validate the Form

			$formErrors = array();

			if (empty($username) || empty($email) || empty($fullname)) {
				$formErrors[] = "<div class='alert alert-danger'>You must full all empties!</div>";
			} if (strlen($username) < 3) {
				$formErrors[] = "<div class='alert alert-danger'>Username can't be less than <strong>3 CHAR</strong></div>";
				//LOOP ento Errors array and echo it
			} foreach ($formErrors as $errors) {
				echo $errors;
			}

			if (empty($formErrors)) {
				// Update on Database
				$stmt = $con->prepare("UPDATE users SET Username = ? , Password = ? , Email = ? , FullName = ? WHERE UserID = ?");
				$stmt->execute(array($username , $pass , $email , $fullname , $id));

				echo "<div class='alert alert-success sweetSuc'>" . $stmt->rowCount() . 'Record Updated </div>';
			}
			
		} else {
			$errorMsg = "SORRY! You can not Browse this page ..";

			redirectHome($errorMsg , 5);
		}
		echo "</div>";

		/*================================== Delete Page =============================*/
	} elseif ($do == 'Delete') {

		echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Delete Members</h1>";
		echo "<div class='container'>";

		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

		$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?  LIMIT 1");
		$stmt->execute(array($userid));
		$count = $stmt->rowCount();

		if ($stmt->rowCount() > 0) {

		$stmt = $con->prepare("DELETE FROM users WHERE UserID = :user");
		$stmt->bindParam(":user" , $userid);
		$stmt->execute();

		echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted' . "</div>";
		} else {
			$theMsg = " This ID is not Exist! ";
			redirectHome($theMsg, 3);
		}
		echo "</div>";

		/*============================= Activate Page ========================= */

	} elseif ($do == 'Activate') {

		echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Activate Members</h1>";
		echo "<div class='container'>";

		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

		$check = checkItem('userid' , 'users' , $userid);

		if ($check > 0) {

			$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
			$stmt->execute(array($userid));

			/*$stmt = $con->prepare("SELECT Username FROM users WHERE UserID = ? ");
			$stmt->execute();
			$rows = $stmt->fetchAll();

			foreach ($rows as $row) {*/
				echo "<div class='alert alert-success'>" .  $stmt->rowCount() . ' Record Activated' . "</div>";
			

		} else {
			$theMsg = "<div class='alert alert-danger'> This ID is not Exist! </div>";
			redirectHome($theMsg, 3);
		}
		echo "</div>";
	}

		include $tpl . 'footer.php';
	
	} else { 
	
		header('Location: index.php');

		exit();
	
	}

	ob_end_flush();

?>