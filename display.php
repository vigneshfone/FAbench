<?php
ini_set('display_erors',1);
include_once 'style.php';
include_once 'config.php';
require_once 'phplot/phplot.php';

if(!empty($_REQUEST['searchable'])) {
   $matches = implode(',', $_REQUEST['searchable']);
   $data = array();
   $current_phone_id=$_REQUEST['current_phone'];
   $title= $_REQUEST['title'];
   $subtitle= $_REQUEST['subtitle'];
   $image_name= $_REQUEST['image'];
} else {
echo "Slelect any phones to display chart";
exit;
}
$db = new DB_Class();
$result = mysql_query("select phone_name, quadrant from benchmarks left join phone on benchmarks.phone_id= phone.phone_id where quadrant <> 0 and benchmarks.phone_id in ($matches) order by quadrant asc");
$n_rows = mysql_num_rows($result);
$current = mysql_query("select phone_name from phone where phone_id= $current_phone_id");
$current_phone = mysql_fetch_assoc($current);
for($i = 0; $i < $n_rows; $i++){
 $data[] = mysql_fetch_row($result);
 }

 //$data=conn();
 $plot = new PHPlot(574, 432);
$plot->SetIsInline(True);
$plot->SetBgImage('watermark.png', 'scale');
//$plot->SetPlotAreaBgImage('Veuqs.png', 'scale');
//$plot->SetPlotAreaPixels(NULL, NULL, 574, 432);
$plot->SetImageBorderType('solid'); // Improves presentation in the manual
$plot->SetTitle($title);
$plot->SetXTitle($subtitle, 'plotup');//modified core file line no 4500 DrawXTitle() for subtitle positioning
$plot->SetMarginsPixels(NULL, 15, 70);
//$plot->SetImageBorderColor('#00f0fa');
$plot->SetBackgroundColor('#ffffff');
$plot->SetPlotAreaWorld(0);
$plot->SetTTFPath('./phplot');
// No ticks along Y axis, just bar labels:
$plot->SetYTickPos('none');
//  No ticks along X axis:
$plot->SetXTickPos('xaxis');
// No X axis labels. The data values labels are sufficient.
$plot->SetXTickLabelPos('xaxis');
// Turn on the data value labels:
$plot->SetXDataLabelPos('plotin');
//$plot->SetXDataLabelAngle(90);
$plot->SetPrecisionX(0);
$plot->SetNumberFormat('', '');
//$plot->SetTransparentColor('#FFCC00');
$plot->SetFontTTF('title', 'arial.ttf', 14);
$plot->SetFontTTF('x_title', 'arial.ttf', 12);
$plot->SetFontTTF('y_label', 'arial.ttf', 10);
$plot->SetFontTTF('x_label', 'arial.ttf', 8);
$plot->SetDataValueLabelColor('#ffffff');
//No grid lines are needed:
$plot->SetDrawXGrid(true);
//$plot->SetLegend(array('quadrant','antutu','example'));
$plot->SetCallback('data_color', 'pickcolor', $data);
// Set the bar fill color:
$plot->SetDataColors(array('#FFCC00','#33AACC'));
// Use less 3D shading on the bars:
$plot->SetShading(10);
$plot->SetDataValues($data);
$plot->SetDataType('text-data-yx');
//$plot->SetPlotType('stackedbars');
$plot->SetPlotType('bars');
$val=rand(1,10);
$plot->SetOutputFile('GeneratedImages/'.$image_name.'.png');
//$plot->SetPrintImage(False);
$plot->DrawGraph(); 

?>
<div class="row">
<div class="span12" style="text-align:center">
<?php
function pickcolor($img, $data_array, $row, $col)
{
global $current_phone;
$current_phone2 = $data_array[$row][0];
if ($current_phone2 == $current_phone['phone_name']) return 0;
return 1;
}
echo "<img src=\"" . $plot->EncodeImage() . "\">\n";
?>
<div class="row" style="margin-top:14px;">
<div class="span12" id="response">
<p>Graph generated in the path: root/GeneratedImages/<?php echo $image_name.'.png';?></p>
</div></div>
</div>

</div>
</div>
