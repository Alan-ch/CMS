<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>
<?php require_once("../includes/validation_functions.php");?>
<?php $layout_context="admin";?>
<?php include("../includes/layouts/header.php");?>
<?php 
  $current_admin = find_admin_by_id($_GET["admin"]); 
  if(!$current_admin){
	  // admin ID was missing or invalid or
	  // admin couldn't be found in database
	  redirect_to("manage_admins.php");
	  
	  
  }
  
  ?>
<?php 

       
if(isset($_POST['submit'])){
	// Process the form
       
	   
		
		// Validations.
		$required_fields = array("username","password");
		validate_presences($required_fields);
		
		$fields_with_max_lenghts = array("username"=>30);
		validate_max_lengths($fields_with_max_lenghts);
	
		
		if(empty($errors)){
			
			//redirect_to("new_admin.php");
			
			$username = mysql_prep($_POST["username"]);
       $hashed_password = password_hash($_POST["password"],PASSWORD_BCRYPT,['cost'=>10]);
	
		 $query = "UPDATE admins SET ";
        $query .= " username ='{$username}', ";
		 $query .= " hashed_password='{$hashed_password}' ";
		$query .= " WHERE id = {$current_admin["id"]} ";
        $query .= " LIMIT 1";
 
        $result = mysqli_query($connection,$query);

        if($result && mysqli_affected_rows($connection)==1){
              	//Success
				  $_SESSION["message"]= "admin updated";
                 	redirect_to("manage_admins.php");
					
		}else{
			// Failer 
			$message=" Admin edited failed.";
	
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
			<?php 
			 
			// $_SESSION["errors"]=$errors;
			 echo form_errors($errors); ?>
	
		  <h2> Edit Admin:<?php echo htmlentities($current_admin["username"]);?> </h2>   
		<form action=" edit_admin.php?admin=<?php echo urlencode($current_admin["id"]);?>" method="post">
		  
		  <p>Username:
		      <input type="text" name="username" value="<?php echo htmlentities($current_admin["username"]);?>"/>
		  </p>	 
            <p>Password:
		      <input type="password" name="password" value=""/>
		  </p>
		   <input type="submit" name="submit" value="Edit Admin"/>
			
			   
		</form>	   
		<br/>
		<a href="manage_admins.php">Cancel</a>
			
		  
			
	    </div>
		
  </div>   
	

   <?php include("../includes/layouts/footer.php");?>
   
 