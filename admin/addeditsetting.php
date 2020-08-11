<?php
$id = '';
if(isset($_GET['id']))
{
	$id = dec_password($_GET['id']);
	$record = get_records($tblsettings,"id='".$id."'");
	if(isset($record[0])){
		foreach ($record[0] as $k => $v )
		{
			$_SESSION['sysData'][$k] = stripslashes($v);
		}
	}
}
else if(!isset($_SESSION['sysData']['id'])) {
	$_SESSION['sysData'] = table_fields($tblsettings);
}
?>
<form action="process.php?p=addeditsetting" enctype="multipart/form-data" method="post">
<div class="row">
    <div class="col-md-12">
        <div class="card">
            
                <div class="header">
                    <h4 class="title">Update Setting</h4>
                </div>
                <?php show_errors();?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?php echo $_SESSION['sysData']['option_name'];?> <span class="err">*</span></label>
                            <textarea required class="form-control" id="value_name" name="value_name" placeholder="Setting value"><?= $_SESSION['sysData']['value_name'];?></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="<?php echo enc_password($_SESSION['sysData']['id']); ?>" />
                <input type="hidden" name="option_name" id="option_name" value="<?php echo $_SESSION['sysData']['option_name']; ?>" />
                <button type="submit" class="btn btn-info btn-fill" name="submit">Submit</button>
                <div class="clearfix"></div>
		</div>
	</div>
</div>
</form>