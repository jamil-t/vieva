<style>
a.pagination { padding:2px 5px; margin:1px; background-color:#fff; border:1px solid #aaa; }
a.pagination:hover { background-color:#ccc; color:#aaa; }
span.pagination { padding:2px 5px; margin:1px; color:#fff; background-color:#666; border:1px solid #aaa; }
</style>
<?php
if($total_results>0)
{
	// Figure out the total number of pages. Always round up using ceil() 
	$total_pages = ceil($total_results / $max_results); 
	
	$pagination_link = getpage_url();
	$pagination_arr = explode('&pageNo=',$pagination_link);
	$pagination_link = $pagination_arr[0];
	
	$pagination_start = (($pageNo * $max_results) - $max_results)+1;
	$pagination_end = $pagination_start+$max_results-1;
	$pagination_end = ($total_results>$pagination_end)?$pagination_end:$total_results;
	echo $pagination_start.' to '.$pagination_end.' of '.$total_results;
	if($total_pages > 1)
	{
		echo ',&nbsp;&nbsp;&nbspShowing page <select onchange="window.location=this.value;">';
		
		for($i = 1; $i <= $total_pages; $i++){
			if(($pageNo) == $i){
				echo '<option selected="selected" value="'.$pagination_link.'&pageNo='.$i.'">'.$i.'</option>';
			} else {
				echo '<option value="'.$pagination_link.'&pageNo='.$i.'">'.$i.'</option>';
			}
		} 
		
		echo '</select>';
	}
}
?>