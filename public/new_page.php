<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>
<?php $layout_context="admin";?>
<?php include("../includes/layouts/header.php");?>

<?php     find_selected_page(); ?>

	<div id="main">
		<div id="navigation">
          <?php echo navigation($current_subject,$current_page);?>
	</div>
	<?php $_SESSION["id"]=$current_subject["id"];?>
		  
	<div id="page"> 
			<?php 
			   echo message();
			?>
			<?php $errors = errors();?>
			<?php echo form_errors($errors); ?>
	
		  <h2> Create Page </h2>   
	   	<form action="create_page.php" method="post">
		  
		  <p>Menu name:
		      <input type="text" name="menu_name" value=""/>
		  </p>	 

			<p>Position:
			<select name="position">
			<?php 
			for($count=1;$count<=($_GET["nbpage"]+1);$count++){
				echo "<option value=\"{$count}\">{$count}</option>";
			}
			?>
			 </select>
			 
			 <p> Visible:
			   <input type="radio" name="visible" value="0"/> No
			   &nbsp;
			   <input type="radio" name="visible" value="1"/> Yes
			  </p> 
			  
			  Content:
			  <br/>
			  <textarea name="content" rows="20" cols="80"></textarea>
			  <br/>
			  
			  
			   <input type="submit" name="submit" value="Create Page"/>
			   
		     </form>	   
		
		     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]);?>">Cancel</a>
			
		  
			
	    </div>
		
  </div>   
	

   <?php include("../includes/layouts/footer.php");?>
   
 