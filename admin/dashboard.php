<?php

									/*==========================
								  	*****  Dashboard Page  *****
									==========================*/


	ob_start();
	session_start();
	if (isset($_SESSION['Username'])) {
		
		$pageTitle = 'Dashboard';

		include 'init.php';
/*=================================================================================*/
	?>
 
 	<section class="loading">
 		<div class="spinner"></div>
 	</section>

<div class="mr">
	<div class="container home-stats text-center">
		<h1>Dashboard</h1>
		<div class="row">
			<div class="col-md-3 wow fadeInLeft" data-wow-duration="2s">
				<a href="members.php"><div class="stat members">
					<i class="fa fa-users"></i>
					<div class="info">
					Total Members
					<span><?php echo countItems('UserID', 'users'); ?></span>
					</div>
				</div></a>
			</div>
			<div class="col-md-3 wow fadeInDown" data-wow-duration="1.5s">
				<a href="members.php?do=Manage&page=Pending">
					<div class="stat pending">
						<i class="fa fa-plus"></i>
						<div class="info">
							Pending Members
							<span>
							<?php echo checkItem('RegStatus', 'users', 0); ?></span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-3 wow fadeInUp" data-wow-duration="1.5s">
				<a href="items.php"><div class="stat items">
					<i class="fa fa-tag"></i>
					<div class="info">
						Items
						<span><?php echo countItems('Item_ID', 'item'); ?></span>
					</div>
				</div></a>
			</div>
			<div class="col-md-3 wow fadeInRight" data-wow-duration="2s">
				<a href="">
					<div class="stat comments">
						<i class="fa fa-comments"></i>
						<div class="info">
							Comments
							<span>0</span>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>

	<div class="container letest">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<?php $latest = 8 ?>
  					<div class="panel-heading">
  					<i class="fa fa-users"></i>
  					Letest <?php echo $latest ?> Registerd Users
  					<span class="toggle-info pull-right"><i class="fa fa-minus fa-lg"></i></span>
  					</div>
 					<div class="panel-body">
	 					<ul class="list-unstyled letest-users">
	<?php 

	    					$theLetest = getLetest('*' , 'users' , 'UserID' , $latest);
	    					foreach ($theLetest as $username) {
		    					echo '<li><i class="fa fa-user"></i>' . $username['FullName'] .
		    							"<a href = 'members.php?do=Edit&userid=". $username['UserID'] ."'>" .
		    								"<span class='btn btn-success pull-right' title='تعديل'><i class='fa fa-edit'></i> ";
		    								if ($username['RegStatus'] == 0) {
													echo "<a class='btn btn-info active pull-right' href='members.php?do=Activate&userid="
													. $username['UserID'] ."' title='تفعيل'><i class='fa fa-check'></i>Active</a>";
												}
										echo "</span>" .
		    							'</a>' .
		    						 '</li>';
	    						}

	?>
	    				</ul>
 					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<?php $latest = 8 ?>
  					<div class="panel-heading">
  					<i class="fa fa-tag"></i>
  					Letest <?php echo $latest ?> Registerd Items
  					<span class="toggle-info pull-right"><i class="fa fa-minus fa-lg"></i></span>
  					</div>
 					<div class="panel-body">
	 					<ul class="list-unstyled letest-users">
	<?php 

	    					$theLetest = getLetest('*' , 'item' , 'Item_ID' , $latest);
	    					foreach ($theLetest as $item) {
		    					echo '<li><i class="fa fa-tag"></i>' . $item['Name'] .
		    							"<a href = 'items.php?do=Edit&itemid=". $item['Item_ID'] ."'>" .
		    								"<span class='btn btn-success pull-right' title='تعديل'><i class='fa fa-edit'></i> ";
										echo "</span>" . '</a>';
		    							if ($item['Approve'] == 0) {
										
													echo "<a class='btn btn-info active pull-right' href='items.php?do=Approve&itemid="
													. $item['Item_ID'] ."' title='تفعيل'><i class='fa fa-check'></i>Approve</a>";
												}
		    						    echo '</li>';
	    						}
	?>
	    				</ul>
 					</div>
				</div>
			</div>
		</div>
<!--   Start Latest Comments   -->
		<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<?php $latest = 8 ?>
	  					<div class="panel-heading">
	  					<i class="fa fa-comment-o"></i>
	  					Letest Comments
	  					<span class="toggle-info pull-right"><i class="fa fa-minus fa-lg"></i></span>
	  					</div>
	 					<div class="panel-body">

	 					<?php
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

						foreach ($rows as $row) {
							echo "<div class='comment-box'>";
								echo '<span class="member-n">' . $row['Member'] . "</span>" . '<p class="member-c">' . $row['comment'] . '</p>';
							echo "</div>";
						}
	 					 ?>

	 					</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<?php $latest = 8 ?>
	  					<div class="panel-heading">
	  					<i class="fa fa-tag"></i>
	  					Letest <?php echo $latest ?> Registerd Items
	  					<span class="toggle-info pull-right"><i class="fa fa-minus fa-lg"></i></span>
	  					</div>
	 					<div class="panel-body">
		 					<ul class="list-unstyled letest-users">
		<?php 

		    					$theLetest = getLetest('*' , 'item' , 'Item_ID' , $latest);
		    					foreach ($theLetest as $item) {
			    					echo '<li><i class="fa fa-tag"></i>' . $item['Name'] .
			    							"<a href = 'items.php?do=Edit&itemid=". $item['Item_ID'] ."'>" .
			    								"<span class='btn btn-success pull-right' title='تعديل'><i class='fa fa-edit'></i> ";
											echo "</span>" . '</a>';
			    							if ($item['Approve'] == 0) {
											
														echo "<a class='btn btn-info active pull-right' href='items.php?do=Approve&itemid="
														. $item['Item_ID'] ."' title='تفعيل'><i class='fa fa-check'></i>Approve</a>";
													}
			    						    echo '</li>';
		    						}
		?>
		    				</ul>
	 					</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>
<?php	
/*=================================================================================*/
		include $tpl . 'footer.php';
	
	} else { 
	
		header('Location: index.php');
		exit();
	
	}

	ob_end_flush();
?>