<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>

<?php require_once("../includes/validation_functions.php");?>
<?php $layout_context="admin";?>
<?php include("../includes/layouts/header.php");?>


<?php 

if(isset($_POST['submit'])){
	// Process the form
    
		
		// Validations.
		$required_fields = array("username","password");
		validate_presences($required_fields);
		
		$fields_with_max_lenghts = array("username"=>30);
		validate_max_lengths($fields_with_max_lenghts);
		
		if(empty($errors)){
			$username = mysql_prep($_POST["username"]);
       $hashed_password = pass_hash($_POST["password"],PASS_DEF);
			
        $query = "INSERT INTO admins(";
        $query .= " username,hashed_password";// here all my column in one line
        $query .= ") VALUES (";
        $query .= " '{$username}','{$hashed_password}'";// and all my data in one line 
        $query .=")";
 
        $result = mysqli_query($connection,$query);

        if($result){
              	//Success
				  $_SESSION["message"]= "admin created";
                 	redirect_to("manage_admins.php");
					
		}else{
			// Failer 
			$_SESSION["message"]= "admin creation failed";
		}
	         
	
			}


	
	
} else {//probably here i was a GET request ..someone went to their url and typed create_subject.php.
	//redirect_to("new_admin.php");
	
	
	
       }








?>

	<div id="main">
		<div id="navigation">
          
	</div>
		  
	<div id="page"> 
			<?php 
			   echo message();
			?>
			<?php// $errors = errors();?>
			<?php echo form_errors($errors); ?>
	
		  <h2> Create Admin </h2>   
		<form action=" new_admin.php" method="post">
		  
		  <p>Username:
		      <input type="text" name="username" value=""/>
		  </p>	 
            <p>Password:
		      <input type="password" name="password" value=""/>
		  </p>
		   <input type="submit" name="submit" value="Create Admin"/>
			
			   
		</form>	   
		<br/>
		<a href="manage_admins.php">Cancel</a>
			
		  
			
	    </div>
		
  </div>   
	

   <?php include("../includes/layouts/footer.php");?>
   
 