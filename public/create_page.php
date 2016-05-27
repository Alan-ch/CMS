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
		$content = mysql_prep($_POST["content"]);
		$subject_id=$_SESSION["id"];
		// Validations.
		$required_fields = array("menu_name","position","visible","content");
		validate_presences($required_fields);
		
		$fields_with_max_lenghts = array("menu_name"=>30);
		validate_max_lengths($fields_with_max_lenghts);
		
		if(!empty($errors)){
		
			$_SESSION["errors"]=$errors;
			$output="new_page.php?subject=";
			$output.="{$subject_id}& nbpage={$_SESSION[nbpage]}";
			redirect_to($output );
			
		}
		

        $query = "INSERT INTO pages(";
        $query .= " subject_id, menu_name, position, visible, content";// here all my column in one line
        $query .= ") VALUES (";
        $query .= " {$subject_id},'{$menu_name}',{$position},{$visible}, '{$content}'";// and all my data in one line 
        $query .=")";
 
        $result = mysqli_query($connection,$query);

        if($result){
              	//Success
				$subject_id=urlencode($subject_id);
				  $_SESSION["message"]= "page created";
               $output="manage_content.php?subject=";
			$output.="{$subject_id}";
			redirect_to($output );
					
		}else{
			// Failer 
			$_SESSION["message"]= "page creation failure";
			redirect_to("new_page.php");
	         
	
			}


	
	
} else {//probably here i was a GET request ..someone went to their url and typed create_subject.php.
	redirect_to("new_page.php");
	
	
	
       }








?>

 <?php  if(isset($connection)){mysqli_close($connection);} ?>