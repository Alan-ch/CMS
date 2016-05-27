<?php 
function redirect_to($new_location){
header("Location: " . $new_location);
	exit;
}
function mysql_prep($string){
	global $connection;
	$escaped_string= mysqli_real_escape_string($connection,$string);
	return $escaped_string;
	
}
function confirm_query($result_set){
	
	if(!$result_set){
		die(" Database query failed ");	
	}
	
}
// this function copy from validations_errors.php
function form_errors($errors=array()){
		$output="";
		
		if(!empty($errors)) {
		
		$output .= "<div class=\"error\">";
		$output.= "please fix the following errors:" ;
		$output.="<ul>";
		foreach ($errors as $key => $error) {
		$output.= "<li>";
		$output.= htmlentities($error) ;
		$output.= "</li>";
		}
		$output.= "</ul>";
		$output.= "</div>";}
		
		return $output;	
		
	}
function find_all_subject($public=true){
// 2. perform database query
//$query = "SEECT * FROM subjects "; if remove l from select..-> failure
//$query = "SElECT * FROM subjects WHERE id=2000"; here not failure because any rows means there are results...
global $connection;// better place to use global variable
$query = "SELECT * ";// Space after *
 $query .= "FROM subjects ";// Space after subjects
 if($public){$query.="WHERE visible=1 " ;}
 $query .="ORDER BY position ASC ";
$subject_set = mysqli_query($connection,$query);
// Test if there was a query error
confirm_query($subject_set);
return $subject_set;

}
function find_all_admins(){
// 2. perform database query
//$query = "SEECT * FROM subjects "; if remove l from select..-> failure
//$query = "SElECT * FROM subjects WHERE id=2000"; here not failure because any rows means there are results...
global $connection;// better place to use global variable
$query = "SELECT * ";// Space after *
 $query .= "FROM admins ";// Space after subjects
 $query .="ORDER BY username ASC ";
$admin_set = mysqli_query($connection,$query);
// Test if there was a query error
confirm_query($admin_set);
return $admin_set;

}
function find_pages_for_subjects($subject_id,$public=true){

	global $connection;
	$safe_subject_id= mysqli_real_escape_string($connection,$subject_id);
	$query = "SELECT * ";
    $query .= "FROM pages ";// Space after subjects
	$query .="WHERE subject_id={$safe_subject_id}  ";// dont forget the space
    
   if($public){$query .="AND visible= 1 ";} // Space after 1}
    $query .="ORDER BY position ASC";
   
    $page_set = mysqli_query($connection,$query);
     // Test if there was a query error
       confirm_query($page_set);
	   return $page_set;
}
function find_default_page_for_subject($subject_id){
	$page_set=find_pages_for_subjects($subject_id);
	if($first_page=mysqli_fetch_assoc($page_set)){
		return $first_page;
		
	}else{
		return null;
	}
		
}
function find_selected_page($public=false){
	global $current_subject;
	global $current_page;
	
	if(isset($_GET["subject"])){ 
	
	    $current_subject=find_subject_by_id($_GET["subject"],$public);
	    if($current_subject && $public){
	    $current_page=find_default_page_for_subject($current_subject["id"]) ;
	    }else{$current_page=null;}
	
    }elseif (isset($_GET["page"])){
	$current_page=find_page_by_id($_GET["page"],$public);
	$current_subject= null;
    }else{
	$current_page=null;
	$current_subject=null;
    }
	
	
	
}
function navigation($subject_array,$page_array){
	
	// navigation takes 2 arguments
	// - the current subject array or null 
	// - the current page array or null 
	$output="<ul class=\"subjects\">";
		  $subject_set= find_all_subject(false);





//3. Use returned data (if any)
	     while($subject=mysqli_fetch_assoc($subject_set)){
		// output data from each row 
	
	
	 
	      $output.= "<li";
		  if($subject_array && $subject_array["id"]==$subject["id"]){
		  $output.=" class=\"selected\"";}
		  $output.= ">" ;   
	  
	
	   $output.="<a href=\"manage_content.php?subject= ";
	   $output.= urlencode($subject["id"]) ;
	  $output.= "\"> ";  
	   $output.= htmlentities($subject["menu_name"]);
	  $output.= "</a>";
	  
	
		 $page_set= find_pages_for_subjects($subject["id"],false);

	
	    $output.="<ul class=\"pages\">";
         
            //3. Use returned data (if any)
	       while($page=mysqli_fetch_assoc($page_set)){
		    // output data from each row 
		    	
	
         	
	      $output.= "<li";
		  if($page_array && $page_array["id"]==$page["id"]){
		  $output.=" class=\"selected\"";}
		  $output.= ">" ;   
	  
			
			$output.="<a href=\"manage_content.php?page= ";
			 $output.= urlencode($page["id"]) ;
			 $output.="\">";
			  $output.= htmlentities($page["menu_name"]);
			  $output.="</a></li>";



			
	
             }   
		   
	            
                    // 4. Release returned data
                  mysqli_free_result($page_set);// right here after we are done with the page  

	
	    $output.= "</ul></li>";
	
		
   }  

	
// 4. Release returned data
mysqli_free_result($subject_set);

	
$output.="</ul>";
	
	return $output;
	
}

function find_subject_by_id($subject_id,$public=true){
	global $connection;// better place to use global variable
	$safe_subject_id= mysqli_real_escape_string($connection,$subject_id);
$query = "SELECT * ";// Space after *
 $query .= "FROM subjects ";// Space after subjects
 $query .="WHERE id={$safe_subject_id} ";// Space after 
  if($public){$query .="AND visible= 1 ";} // Space after 1}
 
 $query .=" LIMIT 1";// return one thing
$subject_set = mysqli_query($connection,$query);
// Test if there was a query error
confirm_query($subject_set);
if($subject=mysqli_fetch_assoc($subject_set)){;// good idea to save step..if here maybe it find nothing row..
return $subject;
}else{
	return null;
		
}
	
}
function find_admin_by_id($admin_id){
	global $connection;// better place to use global variable
	$safe_admin_id= mysqli_real_escape_string($connection,$admin_id);
$query = "SELECT * ";// Space after *
 $query .= "FROM admins ";// Space after subjects
 $query .="WHERE id={$safe_admin_id} ";// Space after 
 $query .=" LIMIT 1";// return one thing
$admin_set = mysqli_query($connection,$query);
// Test if there was a query error
confirm_query($admin_set);
if($admin=mysqli_fetch_assoc($admin_set)){;// good idea to save step..if here maybe it find nothing row..
return $admin;
}else{
	return null;
		
}
	
}
function find_admin_by_username($username){
	global $connection;// better place to use global variable
	$safe_username= mysqli_real_escape_string($connection,$username);
$query = "SELECT * ";// Space after *
 $query .= "FROM admins ";// Space after subjects
 $query .="WHERE username='{$safe_username}' ";// Space after 
 $query .=" LIMIT 1";// return one thing
$admin_set = mysqli_query($connection,$query);
// Test if there was a query error
confirm_query($admin_set);
if($admin=mysqli_fetch_assoc($admin_set)){;// good idea to save step..if here maybe it find nothing row..
return $admin;
}else{
	return null;
		
}
}
function find_page_by_id($page_id,$public=true){
	global $connection;// better place to use global variable
	$safe_page_id= mysqli_real_escape_string($connection,$page_id);
$query = "SELECT * ";// Space after *
 $query .= "FROM pages ";// Space after pages
 $query .="WHERE id={$safe_page_id} ";// Space after 1
 if($public){$query .="AND visible=1 ";}
 $query .=" LIMIT 1";// return one thing
$page_set = mysqli_query($connection,$query);
// Test if there was a query error
confirm_query($page_set);
if($page=mysqli_fetch_assoc($page_set)){;// good idea to save step..if here maybe it find nothing row..
return $page;
}else{
	return null;
		
}
	
}
function public_navigation($subject_array,$page_array){
	
	
	
	// navigation takes 2 arguments
	// - the current subject array or null 
	// - the current page array or null 
	$output="<ul class=\"subjects\">";
		  $subject_set= find_all_subject();





//3. Use returned data (if any)
	     while($subject=mysqli_fetch_assoc($subject_set)){
		// output data from each row 
	
	
	 
	      $output.= "<li";
		  if($subject_array && $subject_array["id"]==$subject["id"]){
		  $output.=" class=\"selected\"";}
		  $output.= ">" ;   
	  
	
	   $output.="<a href=\"index.php?subject= ";
	   $output.= urlencode($subject["id"]) ;
	  $output.= "\"> ";  
	   $output.= htmlentities($subject["menu_name"]);
	  $output.= "</a>";
	  
	    if($subject_array["id"]==$subject["id"] || $page_array["subject_id"]==$subject["id"] ){
		 $page_set= find_pages_for_subjects($subject["id"]);

	
	    $output.="<ul class=\"pages\">";
         
            //3. Use returned data (if any)
	       while($page=mysqli_fetch_assoc($page_set)){
		    // output data from each row 
		    	
	
         	
	            $output.= "<li";
		        if($page_array && $page_array["id"]==$page["id"]){
		        $output.=" class=\"selected\"";}
				 
		        $output.= ">" ;   
			    $output.="<a href=\"index.php?page= ";
			    $output.= urlencode($page["id"]) ;
			    $output.="\">";
			    $output.= htmlentities($page["menu_name"]);
			    $output.="</a></li>";

             }   
		   
	             $output.= "</ul>";
              // 4. Release returned data
             mysqli_free_result($page_set);// right here after we are done with the page  
		}
	
	   
		$output.="</li>";// end of the subject li
	
		
   }  

	
// 4. Release returned data
mysqli_free_result($subject_set);

	
$output.="</ul>";
	
	return $output;
	
}




function attempt_login($username,$password){
	// 2 process first : find the username after find the password if matches
	
	$admin=find_admin_by_username($username);
	if($admin){
		// found admin, now check password 
		if(password_verify($password, $admin["hashed_password"])){
			// password matches
			return $admin;
		}else{
			// password does not matches
			return false;
		}
		
		
	}else{
		// admin not found
		
		return false;
	}
	
	
}
function logged_in(){
	// return true or false
	return isset($_SESSION["admin_id"]);
}
	
	
function confirm_logged_in(){
	
	if(!logged_in()){
		
		redirect_to("login.php");
		
		
	}	
}
?>