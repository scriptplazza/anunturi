<?php include("header.php");?>

<section class="col-md-2">

<?php include("left_menu.php");?>
                    
</section><!--col-md-2-->

<section class="col-md-10">

<ol class="breadcrumb">
  <li>Admin CP</li>
  <li>Categories</li>
  <li>Manage Categories</li>
  <li class="active">Edit Category</li>
</ol>

<div class="page-header">
  <h3>Edit Category <small>Edit website categories</small></h3>
</div>

<script src="js/bootstrap-filestyle.min.js"></script>
<script>
$(function(){
$(":file").filestyle({iconName: "glyphicon-picture", buttonText: "Select Photo"});
});
</script>

<script type="text/javascript" src="js/jquery.form.js"></script>

<script>
$(document).ready(function()
{
    $('#categoryForm').on('submit', function(e)
    {
        e.preventDefault();
        $('#submitButton').attr('disabled', ''); // disable upload button
        //show uploading message
        $("#output").html('<div class="alert alert-info" role="alert">Submitting.. Please wait..</div>');
		
        $(this).ajaxSubmit({
        target: '#output',
        success:  afterSuccess //call function after success
        });
    });
});
 
function afterSuccess()
{	
	 
    $('#submitButton').removeAttr('disabled'); //enable submit button
   
}
</script>

<section class="col-md-8">

<div class="panel panel-default">

    <div class="panel-body">
    
<?php

$id = $mysqli->escape_string($_GET['id']); 

if($Categories = $mysqli->query("SELECT * FROM categories WHERE id='$id'")){

    $CategoryRow = mysqli_fetch_array($Categories);
	
    $Categories->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}


?>    

<div id="output"></div>

<form id="categoryForm" action="update_category.php?id=<?php echo $id;?>" method="post">

<div class="form-group">
        <label for="inputTitle">Category</label>
    <div class="input-group">
         <span class="input-group-addon"><span class="glyphicon fa  fa-info"></span></span>
      <input type="text" id="inputTitle" name="inputTitle" class="form-control" placeholder="Edit category" value="<?php echo $CategoryRow['cname'];?>">
    </div>
</div>

<div class="form-group">
        <label for="inputImage">Category Icon (PNG format, Must be square, max-size 150x150)</label>
    <div class="input-group">
         <span class="input-group-addon"><span class="glyphicon fa  fa-info"></span></span>
      <input type="file" name="inputImage" id="inputImage" class="filestyle" data-iconName="glyphicon-picture" data-buttonText="Add Icon">
    </div>
</div>


<div class="form-group">
<label for="inputDescription">Category Description</label>
<textarea class="form-control" id="inputDescription" name="inputDescription" rows="3" placeholder="Edit description of your category"><?php echo $CategoryRow['cat_description'];?></textarea>
</div>


</div><!-- panel body -->

<div class="panel-footer clearfix">

<button type="submit" id="submitButton" class="btn btn-default btn-success btn-lg pull-right">Update Category</button>

</div><!--panel-footer clearfix-->

</form>


</div><!--panel panel-default-->  

</section>

</section><!--col-md-10-->

<?php include("footer.php");?>