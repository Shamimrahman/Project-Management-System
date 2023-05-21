<?php 
include '../../config/db_connect.php';
if(isset($_GET['Id'])){
	$qry = $conn->query("SELECT * FROM task where Id = ".$_GET['Id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
    <dl>
        <dt><b class="border-bottom border-primary">Task</b></dt>
        <dd><?php echo ucwords($Title) ?></dd>
    </dl>
    <dl>
        <dt><b class="border-bottom border-primary">Description</b></dt>
        <dd><?php echo html_entity_decode($Description) ?></dd>
    </dl>
    <dl>
        <dt><b class="border-bottom border-primary">Status</b></dt>
        <dd>
            <?php 
        	if($Status == 1){
		  		echo "<span class='badge badge-secondary'>Pending</span>";
        	}elseif($Status == 2){
		  		echo "<span class='badge badge-primary'>On-Progress</span>";
        	}elseif($Status == 3){
		  		echo "<span class='badge badge-success'>Done</span>";
        	}
        	?>
        </dd>
    </dl>

    <dl>
        <dt><b class="border-bottom border-primary">Estimated Hours</b></dt>
        <dd><?php echo date("F d, Y",strtotime($EstimatedHour)) ?></dd>
    </dl>
    <dl>
        <dt><b class="border-bottom border-primary">Start Date</b></dt>
        <dd><?php echo date("F d, Y",strtotime($StartDate)) ?></dd>
    </dl>
    <dl>
        <dt><b class="border-bottom border-primary">End Date</b></dt>
        <dd><?php echo date("F d, Y",strtotime($EndDate)) ?></dd>
    </dl>

</div>