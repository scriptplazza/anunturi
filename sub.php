<?php include("header_subcat.php");

//Get Total Ads

if($get_total = $mysqli->query("SELECT * FROM ads WHERE subcategory='$cid' AND active=1")){

    $total_ads = $get_total->num_rows;
	
	$get_total->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}



//Get Cat
if($categories = $mysqli->query("SELECT * FROM categories WHERE id='$s_cat_id'")){
	
	$cat_row = mysqli_fetch_array($categories);
	$cat_name = stripslashes($cat_row['cname']);
	$cat_url  = preg_replace("![^a-z0-9]+!i", "-", $cat_name);
	$cat_url  = urlencode(strtolower($cat_url));

$categories->close();

}else{

     printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");

}	

?>

<div class="container container-main">

<div class="col-md-3 col-full col-desktop-only">

<div class="col-right col-rounded">
<h1>Browse</h1>
<ul class="left-navbar">

<li><a href="all-recent-1.html">All Ads</a></li>
<li><a href="featured-recent-1.html">Featured</a></li>
<li><a href="cat-recent-<?php echo stripslashes($cat_row['id']);?>-<?php echo $cat_url;?>-1.html">Back to <?php echo $cat_name;?></a></li>
</ul>
</div>

<?php if(!empty($Ad3)){?>
<div class="ad-block_right">
<?php echo $Ad3;?>
</div>
<?php }?>

</div><!-- /.col-md-3 --> 

<div class="col-md-9 col-full-width col-desktop-only">

<div class="top-navbar col-no-phones">
<span class="strong-label-top pull-left">Sort By:</span>&nbsp
 <div class="dropdown btn-dropdown">

    <button class="btn btn-default btn-custom dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"> <?php if ($id == "recent"){?>Most Recent<?php }else if ($id == "price"){?>Lowest Price<?php }?>
    <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
      <li role="presentation"><a role="menuitem" tabindex="-1" href="sub-recent-<?php echo $cid;?>-<?php echo $name;?>-1.html">Most Recent</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="sub-price-<?php echo $cid;?>-<?php echo $name;?>-1.html">Lowest Price</a></li>
    </ul>
  </div>
<span class="strong-label-top pull-right col-no-phones">Total Number of <?php echo $total_ads;?> Active Ads</span>
</div><!--top-navbar-->

<div class="strong-label-top col-phones">Total Number of <?php echo $total_ads;?> Active Ads</div>

<div class="col-ad-box">

<?php if(!empty($Ad1)){?>

<div class="ad-block-1"><?php echo $Ad1;?></div>

<?php
}

if ($id == "recent"){


// How many adjacent pages should be shown on each side?
	$adjacents = 5;
	
	$query = $mysqli->query("SELECT COUNT(*) as num FROM ads WHERE subcategory='$cid' AND active=1 ORDER BY id DESC");
	
	//$query = $mysqli->query("SELECT COUNT(*) as num FROM photos WHERE  photos.active=1 ORDER BY photos.id DESC");
	
	$total_pages = mysqli_fetch_array($query);
	$total_pages = $total_pages['num'];
	
	$limit = 15; 								//how many items to show per page
	$page = $_GET['page'];
	 
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
 	/* Get data. */
	$result = $mysqli->query("SELECT * FROM ads WHERE subcategory='$cid' AND active=1 ORDER BY id DESC LIMIT $start, $limit");
	 
	//$result = $mysqli->query($sql);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<ul class=\"pagination pagination-lg\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<li><a href=\"subcat-recent-$cid-$name-$prev.html\">&laquo;</a></li>";
		else
			$pagination.= "<li class=\"disabled\"><a href=\"#\">&laquo;</a></li>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
				else
					$pagination.= "<li><a href=\"subcat-recent-$cid-$name-$counter.html\">$counter</a></li>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
					else
						$pagination.= "<li><a href=\"subcat-recent-$cid-$name-$counter.html\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"subcat-recent-$cid-$name-$lpm1.html\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"subcat-recent-$cid-$name-$lastpage.html\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"subcat-recent-$cid-$name-1.html\">1</a></li>";
				$pagination.= "<li><a href=\"subcat-recent-$cid-$name-2.html\">2</a></li>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
					else
						$pagination.= "<li><a href=\"subcat-recent-$cid-$name-$counter.html\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"subcat-recent-$cid-$name-$lpm1.html\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"subcat-recent-$cid-$name-$lastpage.html\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li><a href=\"subcat-recent-$cid-$name-1.html\">1</a></li>";
				$pagination.= "<li><a href=\"subcat-recent-$cid-$name-2.html\">2</a></li>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
					else
						$pagination.= "<li><a href=\"subcat-recent-$cid-$name-$counter.html\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<li><a href=\"subcat-recent-$cid-$name-$next.html\">&raquo;</a></li>";
		else
			$pagination.= "<li class=\"disabled\"><a href=\"#\">&raquo;</a></li>";
		$pagination.= "</ul>\n";		
	}
	
	$query= $mysqli->query("SELECT * FROM ads WHERE subcategory='$cid' AND active=1 ORDER BY id DESC limit $start,$limit");


	$num_of_rows = mysqli_num_rows($query);
	if ($num_of_rows==0)
	{
	echo '<div class="alert alert-danger">There are no content to display at this moment. Check back again soon!!</div>';
	}
	while($row=mysqli_fetch_assoc($query)){
	
	$full_title = stripslashes($row['title']);
	$crop_title = strlen ($full_title);
	if ($crop_title > 60) {
	$sort_title = substr($full_title,0,57).'...';
	}else{
	$sort_title = $full_title;}
	
	$page_link = preg_replace("![^a-z0-9]+!i", "-", $full_title);
	$page_link = urlencode($page_link);
	$page_link = strtolower($page_link);
	
	$location = stripslashes($row['location']);
	$posted_Date = stripslashes($row['date']);
	$price = stripslashes($row['price']);
	
	$feat_image = stripslashes($row['image']);
	
?>

<div class="media col-ad">
   <a class="pull-left" href="ad-<?php echo stripslashes($row['id']);?>-<?php echo $page_link;?>.html">
   <?php if(!empty($feat_image)){?>
      <img class="media-object img-listing" src="thumbs.php?src=http://<?php echo $site_link;?>/uploads/<?php echo $feat_image;?>&amp;h=90&amp;w=140&amp;q=100" 
      alt="<?php echo $full_title;?>">
   <?php }else{?> 
   <img class="media-object img-listing" src="thumbs.php?src=http://<?php echo $site_link;?>/templates/<?php echo $site_template;?>/images/no_img.png&amp;h=90&amp;w=140&amp;q=100" 
      alt="<?php echo $full_title;?>">
   <?php }?>     
   </a>
   <div class="media-body">
      <h4 class="media-heading"><a href="ad-<?php echo stripslashes($row['id']);?>-<?php echo $page_link;?>.html"><?php echo $sort_title;?></a></h4>
      <abbr class="timeago" title="<?php echo $posted_Date;?>"></abbr>, <?php echo $location;?>. 
      
      <p class="strong-label"><?php echo $settings['currency'];?> <?php echo $price;?></p>
   </div>
</div>

<?php }

echo $pagination;

}else if ($id == "price"){

// How many adjacent pages should be shown on each side?
	$adjacents = 5;
	
	$query = $mysqli->query("SELECT COUNT(*) as num FROM ads WHERE subcategory='$cid' AND active=1 ORDER BY price ASC");
	
	//$query = $mysqli->query("SELECT COUNT(*) as num FROM photos WHERE  photos.active=1 ORDER BY photos.id DESC");
	
	$total_pages = mysqli_fetch_array($query);
	$total_pages = $total_pages['num'];
	
	$limit = 15; 								//how many items to show per page
	$page = $_GET['page'];
	 
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
 	/* Get data. */
	$result = $mysqli->query("SELECT * FROM ads WHERE subcategory='$cid' AND active=1 ORDER BY price ASC LIMIT $start, $limit");
	 
	//$result = $mysqli->query($sql);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<ul class=\"pagination pagination-lg\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<li><a href=\"subcat-price-$cid-$name-$prev.html\">&laquo;</a></li>";
		else
			$pagination.= "<li class=\"disabled\"><a href=\"#\">&laquo;</a></li>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
				else
					$pagination.= "<li><a href=\"subcat-price-$cid-$name-$counter.html\">$counter</a></li>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
					else
						$pagination.= "<li><a href=\"subcat-price-$cid-$name-$counter.html\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"subcat-price-$cid-$name-$lpm1.html\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"subcat-price-$cid-$name-$lastpage.html\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"subcat-price-$cid-$name-1.html\">1</a></li>";
				$pagination.= "<li><a href=\"subcat-price-$cid-$name-2.html\">2</a></li>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
					else
						$pagination.= "<li><a href=\"subcat-price-$cid-$name-$counter.html\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"subcat-price-$cid-$name-$lpm1.html\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"subcat-price-$cid-$name-$lastpage.html\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li><a href=\"subcat-price-$cid-$name-1.html\">1</a></li>";
				$pagination.= "<li><a href=\"subcat-price-$cid-$name-2.html\">2</a></li>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
					else
						$pagination.= "<li><a href=\"subcat-price-$cid-$name-$counter.html\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<li><a href=\"subcat-price-$cid-$name-$next.html\">&raquo;</a></li>";
		else
			$pagination.= "<li class=\"disabled\"><a href=\"#\">&raquo;</a></li>";
		$pagination.= "</ul>\n";		
	}
	
	$query= $mysqli->query("SELECT * FROM ads WHERE subcategory='$cid' AND active=1 ORDER BY price ASC limit $start,$limit");


	$num_of_rows = mysqli_num_rows($query);
	if ($num_of_rows==0)
	{
	echo '<div class="alert alert-danger">There are no content to display at this moment. Check back again soon!!</div>';
	}
	while($row=mysqli_fetch_assoc($query)){
	
	$full_title = stripslashes($row['title']);
	$crop_title = strlen ($full_title);
	if ($crop_title > 60) {
	$sort_title = substr($full_title,0,57).'...';
	}else{
	$sort_title = $full_title;}
	
	$page_link = preg_replace("![^a-z0-9]+!i", "-", $full_title);
	$page_link = urlencode($page_link);
	$page_link = strtolower($page_link);
	
	$location = stripslashes($row['location']);
	$posted_Date = stripslashes($row['date']);
	$price = stripslashes($row['price']);
	
	$feat_image = stripslashes($row['image']);
	
?>

<div class="media col-ad">
   <a class="pull-left" href="ad-<?php echo stripslashes($row['id']);?>-<?php echo $page_link;?>.html">
   <?php if(!empty($feat_image)){?>
      <img class="media-object img-listing" src="thumbs.php?src=http://<?php echo $site_link;?>/uploads/<?php echo $feat_image;?>&amp;h=90&amp;w=140&amp;q=100" 
      alt="<?php echo $full_title;?>">
   <?php }else{?> 
   <img class="media-object img-listing" src="thumbs.php?src=http://<?php echo $site_link;?>/templates/<?php echo $site_template;?>/images/no_img.png&amp;h=90&amp;w=140&amp;q=100" 
      alt="<?php echo $full_title;?>">
   <?php }?>     
   </a>
   <div class="media-body">
      <h4 class="media-heading"><a href="ad-<?php echo stripslashes($row['id']);?>-<?php echo $page_link;?>.html"><?php echo $sort_title;?></a></h4>
      <abbr class="timeago" title="<?php echo $posted_Date;?>"></abbr>, <?php echo $location;?>. 
      
      <p class="strong-label"><?php echo $settings['currency'];?> <?php echo $price;?></p>
   </div>
</div>

<?php }

echo $pagination;

}?>

</div><!--/ .col-ad-box-->

<?php if(!empty($Ad2)){?>

<div class="ad-block-2"><?php echo $Ad2;?></div>

<?php }?>

</div><!-- /.col-md-9 --> 

</div><!-- /.container --> 


<?php include("footer.php");?>