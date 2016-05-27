<?php require_once("../includes/session.php");?>
<?php require_once("../includes/db_connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php $layout_context="admin";?>
<?php include("../includes/layouts/header.php");?>

<?php     find_selected_page(); ?>
      
	  <?php global $nbpage;?>
	<div id="main">
		<div id="navigation">
		<br/>
		<a href="admin.php" >&laquo; Main menu</a><br/>
          <?php echo navigation($current_subject,$current_page);?>
		  <br/>
		  <a href="new_subject.php" >+ Add a Subject </a>
	</div>
		  
		<div id="page">
		<?php echo message();?>
		
		  <?php if($current_subject){ ?>
		     <h2> Manage subject </h2>
		    
			Menu name :<?php echo htmlentities($current_subject["menu_name"]);?><br />
			
			Position: <?php echo $current_subject["position"];?><br />
			visible: <?php echo $current_subject["visible"]==1 ? 'yes' : 'no';?><br />
			
			<a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]);?>">Edit Subject</a>
			<br/>
			<br/>
			
			_____________________
			<br/>
			
			<h3>Pages in this subject:</h3>
			<?php $pages_for_subject=find_pages_for_subjects(($current_subject["id"]),false);?>
			
			<?php while($page=mysqli_fetch_assoc($pages_for_subject)){?>
		    <?php $nbpage++;?>
			
         	<ul>
	            <li>
		      <?php if($page){?>
		   
		    <a href="manage_content.php?page=<?php echo urlencode($page["id"]);?>"><?php echo htmlentities($page["menu_name"]);?> </a>
			    </li>
			</ul>

			  
			<?php }}?><br/>
			<br/>
			<?php $_SESSION["nbpage"]=$nbpage;?>
			<a href="new_page.php?subject= <?php echo $current_subject["id"];?> & nbpage=<?php echo urlencode($nbpage);?>"> + Add a new page to this subject </a>
			  
			  
			  <?php }elseif($current_page){?>
		     <h2> Manage page </h2>
		
			Menu name:<?php echo htmlentities($current_page["menu_name"]); ?><br/>
			Position: <?php echo $current_page["position"];?><br />
			visible: <?php echo $current_page["visible"]==1 ? 'yes' : 'no';?><br />
			Content: <br/>
			<div class="view_content">
			 <?php echo htmlentities($current_page["content"]);?>
			
			
			</div>
			<a href="edit_page.php?page= <?php echo urlencode($current_page["id"]);?> "> Edit Page </a>
			
		  <?php } else {?>
		     Please select a subject or a page.
		  <?php }?><br/>
		  <br/>
		  
			
	    </div>
		
  </div>   

   <?php include("../includes/layouts/footer.php");?>