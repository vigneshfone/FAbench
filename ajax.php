<?php
ini_set('display_erors',1);

include_once 'config.php';
$db = new DB_Class();

if($_POST['id'])
{
$processor=$_POST['id'];
//echo $id;
$result = mysql_query("select benchmarks.phone_id, phone_name, $processor from benchmarks left join phone on benchmarks.phone_id= phone.phone_id where $processor <> 0 order by $processor asc");
$data = array();
$n_rows = mysql_num_rows($result);
for($i = 0; $i < $n_rows; $i++){
 $data[] = mysql_fetch_row($result, MYSQL_NUM);
 }
 for($i=0;$i<count($data);$i++)	{ 
			echo '<option value="'.$data[$i][0].'">'.$data[$i][1].'</option>';

		}
} 
?>