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
			<select name="current_phone">
			 <option value="">-- Select Current Phone --</option>
			 <?php for($i=0;$i<count($data);$i++){ ?>
			 <option value="<?php echo $data[$i][1]; ?>"><?php echo $data[$i][1]; ?></option>
			<?php } ?>
			</select>
		</td></tr>
		<tr><td>Enter Title</td><td>
			<input type="text" name="title" class="input-large" placeholder="Enter the Title text for the Graph">
		</td></tr>
		<tr><td>Enter Sub-Title</td><td>
			<input type="text" name="subtitle" class="input-large" placeholder="Enter the Sub-Title text for the Graph">
		</td></tr>
	</table>

		<input type="submit" class="btn btn-primary btn-large" value="Display Graph"/><br/>
	</form> 
	</div>
</div>
<?php 
//print_r($_REQUEST['searchable']);

?>
<script type = "text/javascript">
/* function change(id,name) {
//alert(id+' '+name);
check=document.getElementById("check_list"+id).checked;
//alert(check);
 if (check) {
document.getElementById("phone_name"+id).value = name;
}
else {
document.getElementById("phone_name"+id).value = "";
}
}
 */
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