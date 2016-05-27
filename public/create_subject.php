<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>


<?php 

if(isset($_POST['submit'])){
	// Process the form



       $menu_name = mysql_prep($_POST["menu_name"]);
        $position=(int)$_POST["position"];// if you want use int.
        $visible=(int)$_POST["visible"];
		
		// Validations.
		$required_fields = array("menu_name","position","visible");
		validate_presences($required_fields);
		
		$fields_with_max_lenghts = array("menu_name"=>30);
		validate_max_lengths($fields_with_max_lenghts);
		
		if(!empty($errors)){
			$_SESSION["errors"]=$errors;
			redirect_to("new_subject.php");
			
		}
		

        $query = "INSERT INTO subjects(";
        $query .= " menu_name, position, visible";// here all my column in one line
        $query .= ") VALUES (";
        $query .= " '{$menu_name}',{$position},{$visible}";// and all my data in one line 
        $query .=")";
 
        $result = mysqli_query($connection,$query);

        if($result){
              	//Success
				  $_SESSION["message"]= "subject created";
                 	redirect_to("manage_content.php");
					
		}else{
			// Failer 
			$_SESSION["message"]= "subject creation failure";
			redirect_to("new_subject.php");
	         
	
			}


	
	
} else {//probably here i was a GET request ..someone went to their url and typed create_subject.php.
	redirect_to("new_subject.php");
	
	
	
       }








?>

 <?php  if(isset($connection)){mysqli_close($connection);} ?>