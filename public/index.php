<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php $layout_context="public";?>
<?php include("../includes/layouts/header.php");?>

<?php     find_selected_page(true); ?>
      
	  <?php global $nbpage;?>
	<div id="main">
	
		<div id="navigation">
		
          <?php echo public_navigation($current_subject,$current_page);?>
		 
	    </div>
		  
		<div id="page">
		
		  <h2><?php if($current_page){echo htmlentities($current_page["menu_name"]);}?></h2>
		  <?php if($current_page){echo nl2br(htmlentities($current_page["content"]));?>
		
			
			
		  <?php } else {?>
		     <p> WELCOME! </p>
		  <?php }?><br/>
		  <br/>
		  
			
	    </div>
		
  </div>   

   <?php include("../includes/layouts/footer.php");?>