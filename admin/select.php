<?php
include "db.php";
//$cat= mysqli_query($db,"select * from categories") or die("Selection error".mysqli_error($db));
$cat = get($db,"*","categories","","");
echo "<select>";
echo "<option>Select Category</option>";
while($category = mysqli_fetch_array($cat))
{
	
	echo "<option value='".$category['id']."'>".$category['c_name']."</option>";


	
}
echo "</select>";

?>