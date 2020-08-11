<?php
$search_key = "";
if (isset($_POST['search_key'])) {
    $search_key = $_POST['search_key'];
    $_SESSION['pagination']['search_key'] = $search_key;
} else {
    $search_key = (isset($_SESSION['pagination']['search_key'])) ? $_SESSION['pagination']['search_key'] : "";
}
$_SESSION['pagination']['search_key'] = ($search_key) ? $search_key : "";

$sortby = "";
if (isset($_POST['sortby'])) {
    $sortby = $_POST['sortby'];
    $_SESSION['pagination']['sortby'] = $sortby;
} else {
    $sortby = (isset($_SESSION['pagination']['sortby'])) ? $_SESSION['pagination']['sortby'] : "";
}
$_SESSION['pagination']['sortby'] = ($sortby) ? $sortby : "";

$where = "id>0";

if ($search_key) {
    $where .= " AND (option_name LIKE '%" . $search_key . "%' OR value_name LIKE '%" . $search_key . "%')";
}
if ($sortby) {
    $where .= " ORDER BY $sortby";
}
/////////////////////////////////////////
///////////// Paging /////////////////////
if (!isset($_GET['pageNo'])) {
    $pageNo = 1;
} else {
    $pageNo = $_GET['pageNo'];
}
$from = (($pageNo * $max_results) - $max_results);
$sql = "SELECT * FROM " . $tblsettings . " where " . $where;
$sql_limit = $sql . " LIMIT $from, " . $max_results;
$settings = sql($sql_limit);
/**************************************************************************/
$total_results = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as Num FROM " . $tblsettings . " where " . $where));
$total_results = $total_results['Num'];
////////////////////////////////////////////////////
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <div class="col-md-6">
                    <h4 class="title">Manage Settings</h4>
                </div>
            </div>
            <?php show_errors(); ?>
            <div class="content table-responsive table-full-width">
                <form method="post">
                    <div class="col-md-12" style="border:1px solid #ccc; padding:10px;">
                        <div class="col-md-6">Search Key: <input type="text" name="search_key" placeholder="Name or Value" value="<?= $search_key; ?>" /></div>
                        <div class="col-md-4">
                            Sort By: <select name="sortby">
                                <option <?php if ($sortby == "id desc") { ?> selected="selected" <?php } ?> value="id desc">New First</option>
                                <option <?php if ($sortby == "id asc") { ?> selected="selected" <?php } ?> value="id asc">Old First</option>
                                <option <?php if ($sortby == "option_name asc") { ?> selected="selected" <?php } ?> value="option_name asc">Name ASC</option>
                                <option <?php if ($sortby == "option_name desc") { ?> selected="selected" <?php } ?> value="option_name desc">Name DESC</option>
                            </select>
                        </div>
                        <div class="col-md-2"><input type="submit" name="search" value="Search" /></div>
                    </div>
                </form>
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-12"><?php include("paginglayout.php"); ?></div>
                <div class="col-md-12">&nbsp;</div>
                <table class="table table-hover table-striped mytable">
                    <thead>
                        <tr>
                            <th>Setting Name</th>
                            <th>Setting Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($settings) > 0) {
                            foreach ($settings as $v) {
                                ?>
                                <tr>
                                    <td><?php echo $v['option_name']; ?></td>
                                    <td><?php echo $v['value_name']; ?></td>
                                    <td>
                                        <a href="index.php?p=addeditsetting&id=<?= enc_password($v['id']); ?>" title="Update Record"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td class="err" colspan="3">No record found</td></tr>';
                        }
                        ?>
                        <tr>
                            <td colspan="3"><?php include("paginglayout.php"); ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>