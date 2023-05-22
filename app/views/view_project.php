<?php
include '../../config/db_connect.php';
include '../controllers/TaskController.php';

$stat = array("Pending","Started","On-Progress","On-Hold","Over Due","Done");
$qry = $conn->query("SELECT * FROM project where Id = ".$_GET['Id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
$tprog = $conn->query("SELECT * FROM task where Project_Id = {$Id}")->num_rows;
$cprog = $conn->query("SELECT * FROM task where Project_Id = {$Id} and status = 3")->num_rows;
$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
$prog = $prog > 0 ?  number_format($prog,2) : $prog;
$prod = $conn->query("SELECT * FROM project where Id = {$Id}")->num_rows;
if($Status == 0 && strtotime(date('Y-m-d')) >= strtotime($StartDate)):
if($prod  > 0  || $cprog > 0)
  $Status = 2;
else
  $Status = 1;
elseif($Status == 0 && strtotime(date('Y-m-d')) > strtotime($EndDate)):
$Status = 4;
endif;
$manager = $conn->query("SELECT * FROM users where Id = $Manager_Id");
$manager = $manager->num_rows > 0 ? $manager->fetch_array() : array();
?>
<div class="col-lg-12">
    <div class="row">
        <div class="col-md-12">
            <div class="callout callout-info">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <dl>
                                <dt><b class="border-bottom border-primary">Project Name</b></dt>
                                <dd><?php echo ucwords($ProjectName) ?></dd>
                                <dt><b class="border-bottom border-primary">Description</b></dt>
                                <dd><?php echo html_entity_decode($Description) ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt><b class="border-bottom border-primary">Start Date</b></dt>
                                <dd><?php echo date("F d, Y",strtotime($StartDate)) ?></dd>
                            </dl>
                            <dl>
                                <dt><b class="border-bottom border-primary">End Date</b></dt>
                                <dd><?php echo date("F d, Y",strtotime($EndDate)) ?></dd>
                            </dl>
                            <dl>
                                <dt><b class="border-bottom border-primary">Status</b></dt>
                                <dd>
                                    <?php
									  if($stat[$Status] =='Pending'){
									  	echo "<span class='badge badge-secondary'>{$stat[$Status]}</span>";
									  }elseif($stat[$Status] =='Started'){
									  	echo "<span class='badge badge-primary'>{$stat[$Status]}</span>";
									  }elseif($stat[$Status] =='On-Progress'){
									  	echo "<span class='badge badge-info'>{$stat[$Status]}</span>";
									  }elseif($stat[$Status] =='On-Hold'){
									  	echo "<span class='badge badge-warning'>{$stat[$Status]}</span>";
									  }elseif($stat[$Status] =='Over Due'){
									  	echo "<span class='badge badge-danger'>{$stat[$Status]}</span>";
									  }elseif($stat[$Status] =='Done'){
									  	echo "<span class='badge badge-success'>{$stat[$Status]}</span>";
									  }
									?>
                                </dd>
                            </dl>
                            <dl>
                                <dt><b class="border-bottom border-primary">Project Manager</b></dt>
                                <dd>
                                    <?php if(isset($manager['Id'])) : ?>
                                    <div class="d-flex align-items-center mt-1">
                                        <img class="img-circle img-thumbnail p-0 shadow-sm border-info img-sm mr-3"
                                            src="assets/uploads/<?php echo $manager['Avatar'] ?>" alt="Avatar">
                                        <b><?php echo ucwords($manager['Name']) ?></b>
                                    </div>
                                    <?php else: ?>
                                    <small><i>Manager Deleted from Database</i></small>
                                    <?php endif; ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <span><b>Developers:</b></span>
                    <div class="card-tools">
                        <!-- <button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="manage_team">Manage</button> -->
                    </div>
                </div>
                <div class="card-body">
                    <ul class="users-list clearfix">
                        <?php 
						if(!empty($User_Ids)):
							$members = $conn->query("SELECT * FROM users where Id in ($User_Ids)");
							while($row=$members->fetch_assoc()):
						?>


                        <h1 class="users-list-name text-lg text-capitalize text-bold text-gray"
                            href="javascript:void(0)">
                            <?php echo ($row['Name']) ?>
                        </h1>
                        <!-- <span class="users-list-date">Today</span> -->

                        <?php 
							endwhile;
						endif;
						?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <span><b>Task List:</b></span>
                    <?php if($_SESSION['login_type'] != 2): ?>
                    <div class="card-tools">
                        <button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="new_task"><i
                                class="fa fa-plus"></i> New Task</button>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-condensed m-0 table-hover">
                            <colgroup>
                                <col width="5%">
                                <col width="25%">
                                <col width="30%">
                                <col width="15%">
                                <col width="15%">
                            </colgroup>
                            <thead>
                                <th>#</th>
                                <th>Task</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php 
							$i = 1; //counter var
							$tasks = $conn->query("SELECT * FROM task where Project_Id = {$Id} order by Title  asc");
							while($row=$tasks->fetch_assoc()):
								$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
								unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
								$desc = strtr(html_entity_decode($row['Description']),$trans);
								$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
							?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class=""><b><?php echo ucwords($row['Title']) ?></b></td>
                                    <td class="">
                                        <p class="truncate"><?php echo strip_tags($desc) ?></p>
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
                                    <td class="text-center">
                                        <button type="button"
                                            class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                            data-toggle="dropdown" aria-expanded="true">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" style="">
                                            <a class="dropdown-item view_task" href="javascript:void(0)"
                                                data-id="<?php echo $row['Id'] ?>"
                                                data-task="<?php echo $row['Title'] ?>">View</a>
                                            <div class="dropdown-divider"></div>
                                            <?php if($_SESSION['login_type'] != 2): ?>
                                            <a class="dropdown-item edit_task" href="javascript:void(0)"
                                                data-id="<?php echo $row['Id'] ?>"
                                                data-task="<?php echo $row['Title'] ?>">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_task" href="javascript:void(0)"
                                                data-id="<?php echo $row['Id'] ?>">Delete</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php 
							endwhile;
							?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    .users-list>li img {
        border-radius: 50%;
        height: 67px;
        width: 67px;
        object-fit: cover;
    }

    .users-list>li {
        width: 33.33% !important
    }

    .truncate {
        -webkit-line-clamp: 1 !important;
    }
    </style>

    <script>
    $('#new_task').click(function() {
        uni_modal("New Task For <?php echo ucwords($ProjectName) ?>", "task.php?Project_Id=<?php echo $Id ?>",
            "mid-large")
    })
    $('.edit_task').click(function() {
        uni_modal("Edit Task: " + $(this).attr('data-task'), "task.php?Project_Id=<?php echo $Id ?>&Id=" + $(
                this)
            .attr('data-id'), "mid-large")
    })
    $('.view_task').click(function() {
        uni_modal("Task Details", "view_task.php?Id=" + $(this).attr('data-id'), "mid-large")
    })

    $('.delete_task').click(function() {
        _conf("Are you sure to delete this task?", "delete_task", [$(this).attr('data-id')])
    })
    </script>