<?php
$filename = "KG-AV-".time().'.jpg';
$save = file_put_contents('user_pict/'.$filename, file_get_contents('php://input'));

if ($save>0)
{
	$data['status'] = 'success';
	$data['filename'] = $filename;
}
echo json_encode($data);

?>