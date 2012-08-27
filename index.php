<?php
ini_set('display_erors',1);
include_once 'config.php';
include_once 'style.php';
$db = new DB_Class();
$result = mysql_query("select benchmarks.phone_id, phone_name, quadrant from benchmarks left join phone on benchmarks.phone_id= phone.phone_id where quadrant <> 0 order by quadrant asc");
$data = array();
$n_rows = mysql_num_rows($result);
for($i = 0; $i < $n_rows; $i++){
 $data[] = mysql_fetch_row($result, MYSQL_NUM);
 }
?>
<div class="hero-unit span8">
	<h2>Benchmark Graph Generation</h2>
	<form method="POST" action="display.php" name='display'>
	<table class="table table-bordered table-condensed">
		<tr><td>Select The Phones to Compare</td><td>
			<select id='searchable' multiple='multiple' name="searchable[]">
			<?php for($i=0;$i<count($data);$i++)	{ ?>
			<option value="<?php echo $data[$i][0]; ?>"><?php echo $data[$i][1]; ?></option>
			<?php } ?>
			</select>
		</td></tr>
		<tr><td>Current Phone</td><td>
			<select name="current_phone" id="current_phone">
			 <option value="">-- Select Current Phone --</option>
			 <?php for($i=0;$i<count($data);$i++){ ?>
			 <option value="<?php echo $data[$i][0]; ?>"><?php echo $data[$i][1]; ?></option>
			<?php } ?>
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
$('input#graph').click(function(){
	var current =$('#current_phone').val();
	var phone =$('#searchable').val();
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

</script>
</body>
</html>