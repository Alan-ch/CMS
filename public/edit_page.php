<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>
<?php require_once("../includes/validation_functions.php");?>

<?php     find_selected_page(); ?>

<?php 
// Unlike new_page.php , we don't need a subect_id to be sent 
// we already have it stored in pages.subject_id
    if(!$current_page){
		// page ID was missing or invalid or
		// page couldn't be found in database
		redirect_to("manage_content.php");
		
	}?>
	
	<?php 

if(isset($_POST['submit'])){
	// Process the form
		
		// Validations.
		$required_fields = array("menu_name","position","visible","content");
		validate_presences($required_fields);
		
		$fields_with_max_lenghts = array("menu_name"=>30);
		validate_max_lengths($fields_with_max_lenghts);
		
		if(empty($errors)){
			// Perform Update
			$id=$current_page["id"];
		$menu_name = mysql_prep($_POST["menu_name"]);
        $position=(int)$_POST["position"];// if you want use int.
        $visible=(int)$_POST["visible"];
		$content = mysql_prep($_POST["content"]);

        $query = "UPDATE pages SET ";
        $query .= " menu_name ='{$menu_name}', ";
        $query .= " position ={$position}, ";
		$query .= " visible ={$visible}, ";// don't forget the space..
		$query .= " content ='{$content}' ";
		$query .= " WHERE id = {$id} ";
        $query .= " LIMIT 1";
        $result = mysqli_query($connection,$query);

        if($result && mysqli_affected_rows($connection)>=0){
              	//Success
				  $_SESSION["message"]= "Page Updated.";
                 	redirect_to("manage_content.php");
					
		}else{
			// Failer 
			$message=" Page Updated failed.";
	         
	
			}


	
		}	
} else {//probably here i was a GET request ..someone went to their url and typed create_subject.php.
	
	
	
	
       }// end : if(isset($_POST['submit']))








?>
	
	
	
	
	<?php $layout_context="admin";?>
<?php include("../includes/layouts/header.php");?>



	<div id="main">
		<div id="navigation">
          <?php echo navigation($current_subject,$current_page);?>
	</div>
		  
	<div id="page"> 
			<?php // $message is just a variable , doesn't USE THE SESSION
			   if(!empty($message)){
			   echo "<div class=\"message\">" . htmlentities($message) . "</div>"; }?>
			   
			
			
			<?php echo form_errors($errors); ?>
	
		  <h2> Edit Page: <?php echo htmlentities($current_page["menu_name"]);?> </h2>   
		  
		<form action=" edit_page.php?page=<?php echo urlencode($current_page["id"]);?>" method="post">
		  
		  <p>Menu name:
		      <input type="text" name="menu_name" value="<?php echo htmlentities($current_page["menu_name"]);?>"/>
		  </p>	 

			<p>Position:
			<select name="position">
			<?php 
			
			for($count=1;$count<=($_SESSION["nbpage"]);$count++){
				
			
			echo "<option value=\"{$count}\"";
			if($current_page["position"] == $count){
			echo " selected";
			}
			echo ">{$count}</option>";
			
			}
			
			?>
			 </select>
			 
			 <p> Visible:
			   <input type="radio" name="visible" value="0" <?php if($current_page["visible"]== 0) { echo "checked";}?>/> No
			   &nbsp;
			   <input type="radio" name="visible" value="1" <?php if($current_page["visible"]== 1) { echo "checked";}?>/> Yes
			  </p> 
			 
			   Content:
			  <br/>
			  <textarea name="content" rows="20" cols="80"><?php echo htmlentities($current_page["content"]);?></textarea>
			  <br/>
			  
			  
			  
			   <input type="submit" name="submit" value="Edit Page"/>
			   
		</form>	   
		
		<a href="manage_content.php">Cancel</a>
			&nbsp;
			&nbsp;
		<a href="delete_page.php?page=<?php echo urlencode($current_page["id"]);?>" onclick="return confirm ('are you sure?');">Delete Page</a>
		  
		  
			
	    </div>
		
  </div>   
	

   <?php include("../includes/layouts/footer.php");?>
   
 