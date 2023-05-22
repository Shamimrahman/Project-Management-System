<?php include '../../config/db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=project"><i
                        class="fa fa-plus"></i> Add New project</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table tabe-hover table-condensed" id="list">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="20%">
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Project</th>
                        <th>Task</th>
                        <th>Project Started</th>
                        <th>Project Due Date</th>
                        <th>Project Status</th>
                        <th>Task Status</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
					$i = 1;
					$where = "";
					if($_SESSION['login_type'] == 1){
						$where = " where p.Manager_Id = '{$_SESSION['login_Id']}' ";
					}elseif($_SESSION['login_type'] == 2){
						$where = " where concat('[',REPLACE(p.User_Ids,',','],['),']') LIKE '%[{$_SESSION['login_Id']}]%' ";
					}

					$stat = array("Pending","Started","On-Progress","On-Hold","Over Due","Done");
					$qry = $conn->query("SELECT t.*,p.ProjectName as pname,p.StartDate,p.Status as pstatus, p.EndDate,p.Id as pid FROM task t inner join project p on p.Id = t.Project_Id $where order by p.ProjectName asc");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($row['Description']),$trans);
						$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
						$tprog = $conn->query("SELECT * FROM task where Project_Id = {$row['pid']}")->num_rows;
		                $cprog = $conn->query("SELECT * FROM task where Project_id = {$row['pid']} and status = 3")->num_rows;
						$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
		                $prog = $prog > 0 ?  number_format($prog,2) : $prog;
		                $prod = $conn->query("SELECT * FROM task where Project_Id = {$row['pid']}")->num_rows;
		                if($row['pstatus'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['StartDate'])):
		                if($prod  > 0  || $cprog > 0)
		                  $row['pstatus'] = 2;
		                else
		                  $row['pstatus'] = 1;
		                elseif($row['pstatus'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['EndDate'])):
		                $row['pstatus'] = 4;
		                endif;
					?>

                    <tr>
                        <td class="text-center"><?php echo $i++ ?></td>
                        <td>
                            <p><b><?php echo ucwords($row['pname']) ?></b></p>
                        </td>
                        <td>
                            <p><b><?php echo ucwords($row['Title']) ?></b></p>
                            <p class="truncate"><?php echo strip_tags($desc) ?></p>
                        </td>
                        <td><b><?php echo date("M d, Y",strtotime($row['StartDate'])) ?></b></td>
                        <td><b><?php echo date("M d, Y",strtotime($row['EndDate'])) ?></b></td>
                        <td class="text-center">
                            <?php
							  if($stat[$row['pstatus']] =='Pending'){
							  	echo "<span class='badge badge-secondary'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='Started'){
							  	echo "<span class='badge badge-primary'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='On-Progress'){
							  	echo "<span class='badge badge-info'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='On-Hold'){
							  	echo "<span class='badge badge-warning'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='Over Due'){
							  	echo "<span class='badge badge-danger'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='Done'){
							  	echo "<span class='badge badge-success'>{$stat[$row['pstatus']]}</span>";
							  }
							?>
                        </td>
                        <td>
                            <?php 
                        	if($row['Status'] == 1){
						  		echo "<span class='badge badge-secondary'>Pending</span>";
                        	}elseif($row['Status'] == 2){
						  		echo "<span class='badge badge-primary'>On-Progress</span>";
                        	}elseif($row['Status'] == 3){
						  		echo "<span class='badge badge-success'>Done</span>";
                        	}
                        	?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
table p {
    margin: unset !important;
}

table td {
    vertical-align: middle !important
}
</style>
<script>
$('.view_task').click(function() {
    uni_modal("Task Details", "view_task.php?pid=" + $(this).attr('data-id'), "mid-large")
})
$('.edit_task').click(function() {
    uni_modal("Edit Task: " + $(this).attr('data-task'), "task.php?pid=<?php echo $pid ?>&pid=" + $(
            this)
        .attr('data-id'), "mid-large")
})
</script>