<?php
											/*==========================
										  	*******  Items Page  *******
											==========================*/
	ob_start();
	session_start();

	$pageTitle = 'Items';

	if (isset($_SESSION['Username'])) {
		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {

			$stmt = $con->prepare("	SELECT 
										item.*, categories.Name AS category_name, users.Username 
									FROM 
										item
									INNER JOIN 
										categories 
									ON 
										categories.ID = item.Cat_ID
									INNER JOIN 
										users 
									ON 
										users.UserID = item.Member_ID");
			$stmt->execute();
			$rows = $stmt->fetchAll();


			?>
			<h1 class="text-center wow pulse animated" data-wow-iteration="infinite" data-wow-duration="1500ms">Manage Items</h1>
			<div class="container" style="overflow: hidden;">
				<div class="table-responsive wow fadeInDown">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Name</td>
							<td>Description</td>
							<td>Price</td>
							<td>Adding Date</td>
							<td>Category</td>
							<td>Member</td>
							<td>Control</td>
						</tr>
						<?php
							foreach ($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['Item_ID'] . "</td>";
									echo "<td>" . $row['Name'] . "</td>";
									echo "<td>" . $row['Description'] . "</td>";
									echo "<td>" . $row['Price'] . "</td>";
									echo "<td>" . $row['Add_Date'] ."</td>";
									echo "<td>" . $row['category_name'] ."</td>";
									echo "<td>" . $row['Username'] ."</td>";
									echo "<td> 
												<a class='btn btn-success' href='items.php?do=Edit&itemid="
												. $row['Item_ID'] ."' title='تعديل'><i class='fa fa-edit'></i></a>
												<a class='btn btn-danger confirm' href='items.php?do=Delete&itemid="
												. $row['Item_ID'] ."' title='حذف'><i class='fa fa-close'></i></a>";

												if ($row['Approve'] == 0) {
										
													echo "<a class='btn btn-info active' href='items.php?do=Approve&itemid="
													. $row['Item_ID'] ."' title='تفعيل'><i class='fa fa-check'></i>Approve</a>";
												} 

									echo "</td>";
								echo "</tr>";
							}
						?>
					</table>
				</div>
				<a class="btn btn-primary wow bounceInRight" data-wow-duration="2s" href='items.php?do=Add'><i class="fa fa-plus"></i> Add New Item </a>
			</div>
			
<?php		} elseif ($do == 'Add') { ?>

			<h1 class="text-center wow pulse animated" data-wow-iteration="infinite" data-wow-duration="1500ms">Add New Item</h1>

				<div class="container" style="overflow: hidden;">
					<form class="form-horizontel" action="?do=Insert" method="POST">
					<!-- ***  Start Name Field  *** -->
						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration=".5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Name </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="name" class="form-control" 
								required="required" placeholder="Name Item">
							</div>
						</div>
					<!-- ***  End Name Field  *** -->

					<!-- ***  Start Description Field  *** -->
						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="1s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Description </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="description" class="form-control" 
								required="required" placeholder="Enter Description for your Item">
							</div>
						</div>
					<!-- ***  End Description Field  *** -->

					<!-- ***  Start Price Field  *** -->
						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration="1.5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Price </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="price" class="form-control" 
								required="required" placeholder="Enter Price for your Item">
							</div>
						</div>
					<!-- ***  End Price Field  *** -->

					<!-- ***  Start Country Field  *** -->
						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="2s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Country Made </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="country" class="form-control" 
								required="required" placeholder="Enter Country of made to your Item ..">
							</div>
						</div>
					<!-- ***  End Country Field  *** -->

					<!-- ***  Start Country Field  *** -->
						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration="2.5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Status </label>
							<div class="col-sm-6 col-sm-onset-2">
								<select class="form-control" name="status">
									<option value="0">.....</option>
									<option value="1">New *****</option>
									<option value="2">Like New ****</option>
									<option value="3">Used ***</option>
									<option value="4">Old **</option>
									<option value="5">Very Old *</option>
								</select>
							</div>
						</div>
					<!-- ***  End Country Field  *** -->

					<!-- ***  Start Member Field  *** -->
						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="3s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Member </label>
							<div class="col-sm-6 col-sm-onset-2">
								<select class="form-control" name="member">
									<option value="0">.....</option>
							<?php
							// **** to get all MEMBERS and put results in options **** 
									$stmt  = $con->prepare("SELECT * FROM users");
									$stmt  -> execute();
									$users = $stmt->fetchAll();

									foreach ($users as $user) {
									 	echo "<option value='". $user['UserID'] ."'>". $user['Username'] ."</option>";
									 }
							?>
								</select>
							</div>
						</div>
					<!-- ***  End Member Field  *** -->

					<!-- ***  Start Member Field  *** -->
						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration="3s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Category </label>
							<div class="col-sm-6 col-sm-onset-2">
								<select class="form-control" name="category">
									<option value="0">.....</option>
							<?php
							// **** to get all MEMBERS and put results in options **** 
									$stmt  = $con->prepare("SELECT * FROM categories");
									$stmt  -> execute();
									$cats = $stmt->fetchAll();

									foreach ($cats as $cat) {
									 	echo "<option value='". $cat['ID'] ."'>". $cat['Name'] ."</option>";
									 }
							?>
								</select>
							</div>
						</div>
					<!-- ***  End Member Field  *** -->

					<!-- ***  Start Submit Field  *** -->
						<div class="form-group wow bounceInUp" data-wow-duration="3.5s">
							<div class="col-sm-offset-4 col-sm-8">
								<input type="submit" value="Add Item" class="btn btn-danger btn-lg">	
							</div>
						</div>
					<!-- ***  End Submit Field  *** -->
					</form>
				</div>
			
<?php	}elseif ($do == 'Insert') {
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Insert Item</h1>";
				echo "<div class='container'>";

				$name 			= $_POST['name'];
				$desc 			= $_POST['description'];
				$price 			= $_POST['price'];
				$country 		= $_POST['country'];
				$status   		= $_POST['status'];
				$member 		= $_POST['member'];
				$cat 		   	= $_POST['category'];
				
				// **** Validate the Form ****

				$formErrors = array();

				if (empty($name) || empty($desc) || empty($price) || empty($country)) {
					$formErrors[] = "You must full all empties!";
				} if ( $status == 0) {
					$formErrors[] = "Must Choose <strong>Status</strong>";
				} if ( $cat == 0) {
					$formErrors[] = "Must Choose <strong>Member</strong>";
				} if ( $member == 0) {
					$formErrors[] = "Must Choose <strong>Category</strong>";
				}
					// **** LOOP ento Errors array and echo it ****
				foreach ($formErrors as $errors) {
					echo "<div class='alert alert-danger'>" . $errors . "</div>";
				}

				if (empty($formErrors)) {
					// **** Insert on Database ****
					$stmt = $con->prepare("INSERT INTO item(Name , 	Description , Price , Country_Made , Status , Add_Date , Cat_ID , Member_ID) 
						VALUES(:zname , :zdesc , :zprice , :zcountry , :zstat , now() , :zcat , :zmember)");

					$stmt -> execute(array(
					'zname' 	=> $name,
					'zdesc' 	=> $desc,
					'zprice'	=> $price,
					'zcountry' 	=> $country,
					'zstat' 	=> $status,
					'zcat' 		=> $cat,
					'zmember' 	=> $member
					
					));
					
					echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated </div>';
				} 
			} else {
				echo "<div class='container'>";
					$errorMsg = "SORRY! You can not Browse this page Directly ..";
					redirectHome($errorMsg , 4);
				echo "</div>";
				}

		}elseif ($do == 'Edit') {
			
			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

			$stmt = $con->prepare("SELECT * FROM item WHERE Item_ID = ?");
			$stmt->execute(array($itemid));
			$item = $stmt->fetch();
			$count = $stmt->rowCount();

			if ($count > 0) {
?>

				<h1 class="text-center wow pulse animated" data-wow-iteration="infinite" data-wow-duration="1500ms">Edit Item</h1>

				<div class="container" style="overflow: hidden;">
					<form class="form-horizontel" action="?do=Update" method="POST">
						<input type="hidden" name="itemid" value="<?php echo $itemid ?>">
					<!-- ***  Start Name Field  *** -->
						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration=".5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Name </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="name" class="form-control" 
								required="required" placeholder="Name Item" value="<?php echo $item['Name'] ?>">
							</div>
						</div>
					<!-- ***  End Name Field  *** -->

					<!-- ***  Start Description Field  *** -->
						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="1s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Description </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="description" class="form-control" 
								required="required" placeholder="Enter Description for your Item" value="<?php echo $item['Description'] ?>">
							</div>
						</div>
					<!-- ***  End Description Field  *** -->

					<!-- ***  Start Price Field  *** -->
						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration="1.5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Price </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="price" class="form-control" 
								required="required" placeholder="Enter Price for your Item" value="<?php echo $item['Price'] ?>">
							</div>
						</div>
					<!-- ***  End Price Field  *** -->

					<!-- ***  Start Country Field  *** -->
						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="2s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Country Made </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="country" class="form-control" 
								required="required" placeholder="Enter Country of made to your Item .." value="<?php echo $item['Country_Made'] ?>">
							</div>
						</div>
					<!-- ***  End Country Field  *** -->

					<!-- ***  Start Country Field  *** -->
						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration="2.5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Status </label>
							<div class="col-sm-6 col-sm-onset-2">
								<select class="form-control" name="status">
									<option value="1" <?php if ($item['Status'] == 1 ) echo "selected";?>>New *****</option>
									<option value="2" <?php if ($item['Status'] == 2 ) echo "selected";?>>Like New ****</option>
									<option value="3" <?php if ($item['Status'] == 3 ) echo "selected";?>>Used ***</option>
									<option value="4" <?php if ($item['Status'] == 4 ) echo "selected";?>>Old **</option>
									<option value="5" <?php if ($item['Status'] == 5 ) echo "selected";?>>Very Old *</option>
								</select>
							</div>
						</div>
					<!-- ***  End Country Field  *** -->

					<!-- ***  Start Member Field  *** -->
						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="3s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Member </label>
							<div class="col-sm-6 col-sm-onset-2">
								<select class="form-control" name="member">
		<?php
							// **** to get all MEMBERS and put results in options **** 
									$stmt  = $con->prepare("SELECT * FROM users");
									$stmt  -> execute();
									$users = $stmt->fetchAll();

									foreach ($users as $user) {
									 	echo "<option value='". $user['UserID'] ."'";
									 	if ($item['Member_ID'] == $user['UserID'] ) echo "selected";
									 	echo ">". $user['Username'] ."</option>";
									 }
		?>
								</select>
							</div>
						</div>
					<!-- ***  End Member Field  *** -->

					<!-- ***  Start Member Field  *** -->
						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration="3s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Category </label>
							<div class="col-sm-6 col-sm-onset-2">
								<select class="form-control" name="category">
		<?php
							// **** to get all MEMBERS and put results in options **** 
									$stmt  = $con->prepare("SELECT * FROM categories");
									$stmt  -> execute();
									$cats = $stmt->fetchAll();

									foreach ($cats as $cat) {
									 	echo "<option value='". $cat['ID'] ."'";
									 	if ($item['Cat_ID'] == $cat['ID'] ) echo "selected";
									 	echo ">". $cat['Name'] ."</option>";
									 }
		?>
								</select>
							</div>
						</div>
					<!-- ***  End Member Field  *** -->

					<!-- ***  Start Submit Field  *** -->
						<div class="form-group wow bounceInUp" data-wow-duration="3.5s">
							<div class="col-sm-offset-4 col-sm-8">
								<input type="submit" value="Add Item" class="btn btn-danger btn-lg">	
							</div>
						</div>
					<!-- ***  End Submit Field  *** -->
					</form>

<?php
					$stmt = $con->prepare("	SELECT 
							comments.* , users.Username AS Member
						FROM 
							comments
						INNER JOIN 
							users
						ON 
							users.UserID = comments.user_id
						WHERE 
							item_id = ? ");
					$stmt->execute(array($itemid));
					$rows = $stmt->fetchAll();

					if (!empty($rows)){

?>

						<h1 class="text-center wow pulse animated" data-wow-iteration="infinite" data-wow-duration="1500ms">Manage <?php echo $item['Name'] ?> Comments</h1>
							<div class="table-responsive wow fadeInDown">
								<table class="main-table text-center table table-bordered">
									<tr>
										<td>Comment</td>
										<td>User Name</td>
										<td>Added Date</td>
										<td>Control</td>
									</tr>


									<?php

										foreach ($rows as $row) {
											echo "<tr>";
												echo "<td>" . $row['comment'] . "</td>";
												echo "<td>" . $row['Member'] . "</td>";
												echo "<td>" . $row['comment_date'] ."</td>";
												echo "<td> 
															<a class='btn btn-success' href='comments.php?do=Edit&comid="
															. $row['c_id'] ."' title='تعديل'><i class='fa fa-edit'></i></a>
															<a class='btn btn-danger confirm' href='comments.php?do=Delete&comid="
															. $row['c_id'] ."' title='حذف'><i class='fa fa-close'></i></a>";
													if ($row['status'] == 0) {
													
														echo "<a class='btn btn-info active' href='comments.php?do=Approve&comid="
															. $row['c_id'] ."' title='تفعيل'><i class='fa fa-check'></i>Approve</a>";
													}
												echo "</td>";
											echo "</tr>";
										}

									?>


								</table>
						</div>

					<?php } ?>

				</div>

<?php  
		} else {
			 $errorMsg = "There is NO SUCH ID!!";

			redirectHome($errorMsg);
		}

		} elseif ($do == 'Update') {
			
			echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Update Items</h1>";
		echo "<div class='container'>";

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$id 		= $_POST['itemid'];
			$name 		= $_POST['name'];
			$desc 		= $_POST['description'];
			$price 		= $_POST['price'];
			$country 	= $_POST['country'];
			$status 	= $_POST['status'];
			$cat 	 	= $_POST['category'];
			$member 	= $_POST['member'];
			
			//Validate the Form

			$formErrors = array();

				if (empty($name) || empty($desc) || empty($price) || empty($country)) {
					$formErrors[] = "You must full all empties!";
				} if ( $status == 0) {
					$formErrors[] = "Must Choose <strong>Status</strong>";
				} if ( $cat == 0) {
					$formErrors[] = "Must Choose <strong>Member</strong>";
				} if ( $member == 0) {
					$formErrors[] = "Must Choose <strong>Category</strong>";
				}
					// **** LOOP ento Errors array and echo it ****
				foreach ($formErrors as $errors) {
					echo "<div class='alert alert-danger'>" . $errors . "</div>";
				}

			if (empty($formErrors)) {
				// Update on Database
				$stmt = $con->prepare("UPDATE item SET 
														Name = ? 			,
														Description = ? 	,
														Price = ? 			,
														Country_Made = ? 	,
														Status = ? 			,
														Cat_ID = ? 			,
														Member_ID = ?
													WHERE
														 Item_ID = ? ");
				$stmt->execute(array($name , $desc , $price , $country , $status , $cat , $member , $id)); 

				echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated </div>';
			}
			
		} else {
			$errorMsg = "SORRY! You can not Browse this page ..";

			redirectHome($errorMsg , 5);
		}
		echo "</div>";

		} elseif ($do == 'Delete') {

		echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Delete Item</h1>";
			echo "<div class='container'>";

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

			$check = checkItem('Item_ID' , 'item' , $itemid);

			if ($check > 0) {

				$stmt = $con->prepare("DELETE FROM item WHERE Item_ID = :id");
				$stmt->bindParam(":id" , $itemid);
				$stmt->execute();

				echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted' . "</div>";
			} else {
				$theMsg = " This ID is not Exist! ";
				redirectHome($theMsg, 3);
			}
			echo "</div>";

		} elseif ($do == 'Approve') {

		echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Approve Members</h1>";
		echo "<div class='container'>";

		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

		$check = checkItem('Item_ID' , 'item' , $itemid);

		if ($check > 0) {

			$stmt = $con->prepare("UPDATE item SET Approve = 1 WHERE Item_ID = ?");
			$stmt->execute(array($itemid));

			/*$stmt2 = $con->prepare("SELECT Name FROM item WHERE Item_ID = ?");
			$stmt2->execute();
			$rows = $stmt2->fetchAll();

			foreach ($rows as $row) {*/

				echo "<div class='alert alert-success'>" .  $stmt->rowCount() . ' Record Approved >> ' . $row['Name'] . "</div>";
			//}

		} else {
			$theMsg = "<div class='alert alert-danger'> This ID is not Exist! </div>";
			redirectHome($theMsg, 3);
		}
		echo "</div>";
		}

//  *** =========================================================================== ***

		include $tpl . 'footer.php';
	} else {
		header('Location:index.php');
		exit();
	}

	ob_end_flush();
?>