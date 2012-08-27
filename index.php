<?php
ini_set('display_erors',1);
include_once 'config.php';
include_once 'style.php';
$db = new DB_Class();
$result = mysql_query("select * from benchmarks");

?>
<div class="hero-unit span8">
	<h2>Benchmark Graph Generation</h2>
	<form method="POST" action="display.php" name='display'>
	<table class="table table-bordered table-condensed">
	<tr><td>Select The processor</td><td>
			<select id='processor' name="processor">
			<option value="">-- Select Current Phone --</option>
			 <?php for($i=2;$i<mysql_num_fields($result);$i++){ 
			 $field= mysql_field_name($result, $i);?>
			 <option value="<?php echo $field; ?>"><?php echo $field; ?></option>
			<?php } ?>
			</select>
		<tr><td>Select The Phones to Compare</td><td>
			<select id='searchable' multiple='multiple' name="searchable[]" class="searchable">
			
			</select>
		</td></tr>
		<tr><td>Current Phone</td><td>
			<select name="current_phone" id="current_phone">
			 <option selected="selected" value="">-- Select Current Phone --</option>
			</select>
		</td></tr>
		<tr><td>Enter Title</td><td>
			<input type="text" name="title" class="input-large" placeholder="Enter the Title text for the Graph" required>
		</td></tr>
		<tr><td>Enter Sub-Title</td><td>
			<input type="text" name="subtitle" class="input-large" placeholder="Enter the Sub-Title text for the Graph" required>
		</td></tr>
		<tr><td>Enter Image Name</td><td>
		<div class="input-append">
			<input type="text" name="image" class="input-large" id="appendedInput" placeholder="Enter the name for the Graph image" required>
			<span class="add-on">.png</span>
		</div>
		</td></tr>
	</table>

		<input type="submit" class="btn btn-primary btn-large" id= "graph" value="Display Graph"/><br/>
	</form> 
	</div>
</div>
<?php 
//print_r($_REQUEST['searchable']);

?>
<script type = "text/javascript">
$('#searchable').multiSelect({
  selectableHeader: "<input type='text' id='search' autocomplete='off' placeholder='Phone name'>"
});

$('#search').quicksearch(
  $('li', '#ms-searchable' )).on('keydown', function(e){
    if (e.keyCode == 40){
      $(this).trigger('focusout');
      $('#searchable').focus();
      return false;
    }
  }
);

var j = jQuery.noConflict();
j(document).ready(function()
{

j('input#graph').click(function(){
	var current =j('#current_phone').val();
	var phone =j('#searchable').val();
	var comp = phone.indexOf(current);
	//alert(comp);
	if(phone==null){
	alert('Select any Phones to proceed');
	return false;
	}else if(current==''){
	alert('Select Current Phone to proceed');
	return false;
	}
	else if(comp < 0){
	alert('Select Current Phone only from the list of phones you have selected to proceed');
	return false;
	}
	else{
	return true;
	}
});
j("#processor").change(function()
{
var id=j(this).val();
//alert(id);
j.ajax
({
type: "POST",
url: "ajax.php",
data: {'id':id},
success: function(html)
{
//alert(html);
j('select#searchable').html(html);
j('#current_phone').html(html);
j('select#searchable').multiSelect('refresh');
}
});

});
});



</script>
</body>
</html>