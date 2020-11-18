<?php

								  /*=================================
								  ********  Categories Page  ********
								  =================================*/
	
	ob_start();
	session_start();

	$pageTitle = 'Categories';

	if (isset($_SESSION['Username'])) {
		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
// =================================================================================================================

		if ($do == 'Manage') {

			$sort = 'ASC';
			$sort_array = array('ASC' , 'DESC');

			if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
				$sort = $_GET['sort'];
			}
			
			$stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
			$stmt2->execute();
			$cats = $stmt2->fetchAll();

			?>

			<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Manage Categories</h1>
			<div class="container categories">
				<div> <a class="add-category btn btn-primary pull-right" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Category</a> </div>
				<div class="panel panel-default">
					<div class="panel-heading"> 
						<i class="fa fa-edit" style="padding-right: 5px"></i>Manage Categories
						<div class="ordering pull-right">
							
							<i class='fa fa-sort' style='padding-right: 5px;'></i>Ordering
							
							[ <a class="<?php if($sort == 'ASC'){ echo 'active'; } ?>" href="?sort=ASC">Asc</a> | 
							<a class="<?php if($sort == 'DESC'){ echo 'active'; } ?>" href="?sort=DESC">Desc</a> ]
						</div>
					</div>
					<div class="panel-body">
						<?php 
							foreach ($cats as $cat) {
							echo "<div class='cat'>";
								echo "<div class='hidden-buttons'>";
									echo "<a href='?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-sm btn-primary'><i class='fa fa-edit'></i>Edit</a>";
									echo "<a href='?do=Delete&catid=". $cat['ID'] ."' class='confirm btn btn-sm btn-danger'><i class='fa fa-close'></i>Delete</a>";
								echo "</div>";
									echo "<h3>" . $cat['Name'] . "</h3>";
									echo "<div class='full-view'>";
										echo "<p>"; 
										if ($cat['Description'] == '') {
											echo "This category has no description.";
										} else { echo $cat['Description'];} 
										echo "</p>";
										if( $cat['Visibility'] == 1 ){ echo "<span class='vis-cat'><i class='fa fa-eye' style='padding-right: 5px;'></i>Hidden</span>";
											} else {echo "<span class='vis-cat'><i class='fa fa-eye' style='padding-right: 5px;'></i>Visible</span>";}
										if( $cat['Allow_Comment'] == 1 ){ echo "<span class='com-cat'><i class='fa fa-close' style='padding-right: 5px;'></i>Comment Disabled</span>";}
										if( $cat['Allow_Ads'] == 1 ){ echo "<span class='ads-cat'><i class='fa fa-close' style='padding-right: 5px;'></i>Ads Disabled</span>";}
									echo "</div>";
							echo "</div>";
							echo "<hr>";
							}
						?>
					</div>
				</div>
			</div>
			<?php

		} elseif ($do == 'Add') { ?>

			<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Add New Category</h1>

				<div class="container">
					<form class="form-horizontel" action="?do=Insert" method="POST">
					<!-- Start Name Field -->
						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration=".5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Name </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="name" class="form-control" 
								autocomplete="" required="required" placeholder="Name of the category">	
							</div>
						</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="1s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Description </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="description" class="form-control"
								 placeholder="Description your Category">
							</div>
						</div>
					<!-- End Description Field -->
					<!-- Start Ordering Field -->
						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration="1.5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Ordering </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="ordering" class="form-control" 
								 placeholder="Number to arrange the categories">
							</div>
						</div>
					<!-- End Orderimg Field -->
					<!-- Start Visibility Field -->
						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="2s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Visible </label>
							<div class="col-sm-6 col-sm-onset-2">
								<div>
									<input id="vis-yes" type="radio" name="visibility" value="0" checked />
									<label for="vis-yes">Yes</label>
								</div>
								<div>
									<input id="vis-no" type="radio" name="visibility" value="1" />
									<label for="vis-no">No</label>
								</div>
							</div>
						</div>
					<!-- End Visibility Field -->
					<!-- Start Commenting Field -->
						<div class="form-group form-group-lg wow fadeInLeft" data-wow-duration="2.5s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Allow Commenting </label>
							<div class="col-sm-6 col-sm-onset-2">
								<div>
									<input id="com-yes" type="radio" name="commenting" value="0" checked />
									<label for="com-yes">Yes</label>
								</div>
								<div>
									<input id="com-no" type="radio" name="commenting" value="1" />
									<label for="com-no">No</label>
								</div>
							</div>
						</div>
					<!-- End Commenting Field -->
					<!-- Start Ads Field -->
						<div class="form-group form-group-lg wow fadeInRight" data-wow-duration="3s">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Allow Ads </label>
							<div class="col-sm-6 col-sm-onset-2">
								<div>
									<input id="ads-yes" type="radio" name="ads" value="0" checked />
									<label for="ads-yes">Yes</label>
								</div>
								<div>
									<input id="ads-no" type="radio" name="ads" value="1" />
									<label for="ads-no">No</label>
								</div>
							</div>
						</div>
					<!-- End Ads Field -->
						<div class="form-group wow bounceInUp" data-wow-duration="4s">
							<div class="col-sm-offset-4 col-sm-8">
								<input type="submit" value="Add Category" class="btn btn-danger btn-lg">	
							</div>
						</div>

					</form>
				</div>
			
<?php
		}elseif ($do == 'Insert') {
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Insert Categories</h1>";
					echo "<div class='container' style='color:#FFF;'>";

					$name 		= $_POST['name'];
					$desc 		= $_POST['description'];
					$order 		= $_POST['ordering'];
					$visible 	= $_POST['visibility'];
					$comment 	= $_POST['commenting'];
					$ads 		= $_POST['ads'];
					
					//Validate the Form
					//if (!empty($name)) { 
						
						$check = checkItem('Name', 'categories', $name);

						if ($check == 1) {

							$errorMsg = "<div class='alert alert-danger'>This Category Is Exist!</div>";
							redirectHome($errorMsg, 3);

						} else {
							// Insert in Database
							$stmt = $con->prepare("INSERT INTO categories(Name , Description , Ordering , Visibility , Allow_Comment , Allow_Ads) 
								VALUES(:zname , :zdesc , :zorder , :zvisible , :zcomment , :zads)");

							$stmt -> execute(array(
							'zname' 	=> $name,
							'zdesc' 	=> $desc,
							'zorder'	=> $order,
							'zvisible' 	=> $visible,
							'zcomment' 	=> $comment,
							'zads' 		=> $ads
							
							));
							
							echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated </div>';

						}
					//}
				} else {
						echo '<div class="container">';

						$errorMsg = "SORRY! You can not Browse this page ..";
						redirectHome($errorMsg , 3);

						echo '</div>';
					}
			
		}elseif ($do == 'Edit') {

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

			$stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
			$stmt->execute(array($catid));
			$cat = $stmt->fetch();
			$count = $stmt->rowCount();

			if ($count > 0) {
?>

				<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Edit Category</h1>

				<div class="container">
					<form class="form-horizontel" action="?do=Update" method="POST">
						<input type="hidden" name="catid" value="<?php echo $catid ?>">
					<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Name </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="name" class="form-control" required="required" placeholder="Name of the category" value="<?php echo $cat['Name'] ?>">	
							</div>
						</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Description </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="description" class="form-control"
								 placeholder="Description your Category" value="<?php echo $cat['Description'] ?>">
							</div>
						</div>
					<!-- End Description Field -->
					<!-- Start Ordering Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Ordering </label>
							<div class="col-sm-6 col-sm-onset-2">
								<input type="text" name="ordering" class="form-control" 
								 placeholder="Number to arrange the categories" value="<?php echo $cat['Ordering'] ?>" >
							</div>
						</div>
					<!-- End Orderimg Field -->
					<!-- Start Visibility Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Visible </label>
							<div class="col-sm-6 col-sm-onset-2">
								<div>
									<input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0) echo "checked"; ?> />
									<label for="vis-yes">Yes</label>
								</div>
								<div>
									<input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1) echo "checked"; ?> />
									<label for="vis-no">No</label>
								</div>
							</div>
						</div>
					<!-- End Visibility Field -->
					<!-- Start Commenting Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Allow Commenting </label>
							<div class="col-sm-6 col-sm-onset-2">
								<div>
									<input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0) echo "checked"; ?> />
									<label for="com-yes">Yes</label>
								</div>
								<div>
									<input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1) echo "checked"; ?> />
									<label for="com-no">No</label>
								</div>
							</div>
						</div>
					<!-- End Commenting Field -->
					<!-- Start Ads Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-offset-2 col-sm-2 control-label"> Allow Ads </label>
							<div class="col-sm-6 col-sm-onset-2">
								<div>
									<input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0) echo "checked"; ?> />
									<label for="ads-yes">Yes</label>
								</div>
								<div>
									<input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1) echo "checked"; ?> />
									<label for="ads-no">No</label>
								</div>
							</div>
						</div>
					<!-- End Ads Field -->
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8">
								<input type="submit" value="Save" class="btn btn-primary btn-lg">	
							</div>
						</div>

					</form>
				</div>

<?php  
		} else {
			 $errorMsg = "There is NO SUCH ID!!";

			redirectHome($errorMsg); }

		}elseif ($do == 'Update') {

			echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Updated Category</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$id 		= $_POST['catid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$order 		= $_POST['ordering'];
				$vis	 	= $_POST['visibility'];
				$comment 	= $_POST['commenting'];
				$ads	 	= $_POST['ads'];

				// Update on Database

				$stmt = $con->prepare("UPDATE 
											categories
									   SET 
									   		Name = ? 			,
									   		Description = ? 	, 
									   		Ordering = ? 		, 
									   		Visibility = ? 		, 
									   		Allow_Comment = ? 	, 
									   		Allow_Ads = ?
									   	WHERE 
									   		ID = ?");

				$stmt->execute(array($name , $desc , $order , $vis , $comment , $ads , $id));

				echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated </div>';
				} else {
				$errorMsg = "SORRY! You can not Browse this page ..";

				redirectHome($errorMsg , 5);
			}
			echo "</div>";

		}elseif ($do == 'Delete') {
			echo "<h1 class='text-center wow pulse animated' data-wow-iteration='infinite' data-wow-duration='1500ms'>Delete Category</h1>";
			echo "<div class='container'>";

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

			$check = checkItem('ID' , 'categories' , $catid);

			if ($check > 0) {

				$stmt = $con->prepare("DELETE FROM categories WHERE ID = :id");
				$stmt->bindParam(":id" , $catid);
				$stmt->execute();

				echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted' . "</div>";
			} else {
				$theMsg = " This ID is not Exist! ";
				redirectHome($theMsg, 3);
			}
			echo "</div>";
		}

// =================================================================================================================
		include $tpl . 'footer.php';
	} else {
		header('Location:index.php');
		exit();
	}

	ob_end_flush();
?>