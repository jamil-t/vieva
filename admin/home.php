<?php
    $total_blogs = 0;
    $active_blog = 0;
    $inactive_blog = 0;
    $blogs = get_records($tblblog);
    foreach ($blogs as $key => $v) {
        $total_blogs++;
        if($v['status'] == 1){
            $active_blog++;
        }else{
            $inactive_blog++;
        }
    }
    $total_services = 0;
    $active_service = 0;
    $inactive_service = 0;
    $services = get_records($tblservices);
    foreach ($services as $key => $v) {
        $total_services++;
        if($v['status'] == 1){
            $active_service++;
        }else{
            $inactive_service++;
        }
    }
 ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="header">
                <h4 class="title">Stats Of Blogs</h4>
            </div>
            <div class="content">
            	<div class="row">
                    <div class="col-md-5">Total Blog</div>

                    <div class="col-md-7"><?php echo $total_blogs; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-5">Active Blog</div>
                    <div class="col-md-7"><?php echo $active_blog; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-5">Inactive Blog</div>
                    <div class="col-md-7"><?php echo $inactive_blog; ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card ">
            <div class="header">
                <h4 class="title">Stats Of Services</h4>
            </div>
            <div class="content">
            	<div class="row">
                    <div class="col-md-5">Total Services</div>
                    <div class="col-md-7"><?php echo $total_services; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-5">Active Services</div>
                    <div class="col-md-7"><?php echo $active_service; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-5">Inactive Services</div>
                    <div class="col-md-7"><?php echo $inactive_service; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
