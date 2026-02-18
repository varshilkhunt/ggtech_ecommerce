<?php
function insert($db,$tblname, $fldlist)		
	{
		$fdata="";
		foreach($fldlist as $k=>$v)
		{
			$fdata .= " $k='$v',";   //sname='$n',smobile='$m',
			
		}
		$fdata=trim($fdata,",");  //sname='$n',smobile='$m'
	
		mysqli_query($db,"INSERT INTO $tblname set $fdata");
		
	}
	
function update($db,$tblname, $fldlist, $condition)		//editdata("member", array("name"=>$_POST['txtname'), "pass"=>$_POST['txtpass']), " where id='$id'");
	{
		$fdata="";
		foreach($fldlist as $k=>$v)
		{
			$fdata .= " $k='$v',";
		}
		
		
		$fdata=trim($fdata,",");
		mysqli_query($db,"UPDATE $tblname set $fdata $condition");
	}
	


	function delete($db,$tblname, $condition)		//deldata("member", " where id='$id'");
	{
		mysqli_query($db,"DELETE FROM $tblname $condition");
	}
	
	
	function get($db, $fldlist, $tblname, $condition, $ord)		//getdata("member", "id,name,email,phone", " where cit='$cit'", " order b phonr");
	{
		return mysqli_query($db,"SELECT $fldlist FROM $tblname $condition $ord");
	}



?>