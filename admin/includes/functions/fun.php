<?php  
	
	/*
	==== Title function that echo the page title in case the page
	*/
	function getTitle() {
		global $pageTitle;
		if (isset($pageTitle)) {
			echo $pageTitle;
		} else {
			echo "Defult";
		}
	}

	/*
	==== Home Redirect function[parameters]
	==== $errorMsg = echo the error Messsage
	==== $Seconds = The number of seconds before redirecting
	*/

	function redirectHome($errorMsg,$seconds = 3) {

		echo "<div class='alert alert-danger'>$errorMsg</div>";

		echo "<div class='alert alert-info'>You will Redirect to homepage After $seconds Soconds. </div>";

		header("refresh:$seconds; url = dashboard.php");

		exit();
	}

	/*
	==== Function to check Item in database V1.0
	==== $select = The Items to Select 
	==== $from = The Table to Select Form 
	==== $value = The Value of Select
	*/

	function checkItem($select , $from , $value) {
		
		global $con;

		$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
		$statement->execute(array($value));
		$count = $statement->rowCount();

		return $count;
	}

	/*
	==== Count Number Of Item Function V1.0
	==== $item  = the item to count
	==== $table = the table to choose from
	*/
	function countItems($item, $table) {

		global $con;

		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
		$stmt2->execute();

		return $stmt2->fetchColumn();
	}

	/*
	==== Get Letest Records Function V1.0
	==== $select = The Items to Select 
	==== $table = The Table to Select Form
	==== $limit = Number of Records to Get
	*/ 

	function getLetest($select , $table , $order , $limit = 6) {

		global $con;

		$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
		$getStmt->execute();
		$rows = $getStmt->fetchAll();

		return $rows;

	}