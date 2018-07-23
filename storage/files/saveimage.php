<?php
$filename = "KG-IC-".time().'.jpg';
$save = file_put_contents('logo/'.$filename, file_get_contents('php://input'));

if ($save>0)
{
	$data['status'] = 'success';
	$data['filename'] = $filename;
}
echo json_encode($data);

?>