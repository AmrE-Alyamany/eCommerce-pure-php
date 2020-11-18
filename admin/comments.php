<?php

										/*==========================
									  	*****  Comments Page  ******
										==========================*/
	
	ob_start();
	session_start();
	$pageTitle = 'Comments';
	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {

			$stmt = $con->prepare("	SELECT 
										comments.* , item.Name AS Item_ID , users.Username AS Member
									FROM 
										comments
									INNER JOIN 
										item
									ON 
										item.Item_ID = comments.item_id
									INNER JOIN 
										users
									ON 
										users.UserID = comments.user_id
									 ");
			$stmt->execute();
			$rows = $stmt->fetchAll();


			?>
			<h1 class="text-center wow pulse animated" data-wow-iteration="infinite" data-wow-duration="1500ms">Manage Comments</h1>
			<div class="container" style="overflow: hidden;">
				<div class="table-responsive wow fadeInDown">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>ID</td>
							<td>Comment</td>
							<td>Item Name</td>
							<td>User Name</td>
							<td>Added Date</td>
							<td>Control</td>
						</tr>


						<?php

							foreach ($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['c_id'] . "</td>";
									echo "<td>" . $row['comment'] . "</td>";
									echo "<td>" . $row['Item_ID'] . "</td>";
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
			</div>



	<?php	


			} elseif ($do == 'Edit') {

			$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;

			$stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
			$stmt->execute(array($comid));
			$row = $stmt->fetch();
			$count = $stmt->rowCount();

			if ($count > 0) {


	?>


				<h1 class="text-center wow pulse animated" data-wow-iteration='infinite' data-wow-duration='1500ms'>Edit Comment</h1>

				<div class="container">
					<form class="form-horizontel" action="?do=Update" method="POST">

						<input type="hidden" name="comid" value="<?php echo $comid ?>">

						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration=".5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Comment </label>
							<div class="col-sm-6 col-sm-onset-2">
								<textarea name="comment" class="form-control" autocomplete="off" required="required"><?php echo $row['comment']; ?></textarea>
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
		
		echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Update Comment</h1>";
		echo "<div class='container'>";

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$comid 		= $_POST['comid'];
			$comment 	= $_POST['comment'];
			
			// Update on Database
			$stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");
			$stmt->execute(array($comment, $comid));

			echo "<div class='alert alert-success sweetSuc'>" . $stmt->rowCount() . 'Record Updated </div>';
			
		} else {
			$errorMsg = "SORRY! You can not Browse this page ..";

			redirectHome($errorMsg , 5);
		}
		echo "</div>";

		/*================================== Delete Page =============================*/
	} elseif ($do == 'Delete') {

		echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Delete Members</h1>";
		echo "<div class='container'>";

		$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;

		$stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
		$stmt->execute(array($comid));
		$count = $stmt->rowCount();

		if ($stmt->rowCount() > 0) {

		$stmt = $con->prepare("DELETE FROM comments WHERE c_id = :id");
		$stmt->bindParam(":id" , $comid);
		$stmt->execute();

		echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted' . "</div>";
		} else {
			$theMsg = " This ID is not Exist! ";
			redirectHome($theMsg, 3);
		}
		echo "</div>";

		/*============================= Activate Page ========================= */

	} elseif ($do == 'Approve') {

		echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Activate Members</h1>";
		echo "<div class='container'>";

		$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;

		$check = checkItem('c_id' , 'comments' , $comid);

		if ($check > 0) {

			$stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");
			$stmt->execute(array($comid));

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