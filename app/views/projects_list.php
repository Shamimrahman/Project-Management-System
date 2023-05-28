<?php include '../../config/db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <?php if($_SESSION['login_type'] != 2): ?>
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=project"><i
                        class="fa fa-plus"></i> Add New project</a>
            </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <table class="table tabe-hover table-condensed" id="list">
                <colgroup>
                    <col width="5%">
                    <col width="35%">
                    <col width="15%">
                    <col width="15%">
                    <col width="20%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Project</th>
                        <th>Date Started</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$i = 1;
					$stat = array("Pending","On-Progress","Done");
					$where = "";
					if($_SESSION['login_type'] == 1){
						$where = "where Manager_Id = '{$_SESSION['login_Id']}' ";
					}elseif($_SESSION['login_type'] == 2){
						$where = " where concat('[',REPLACE(User_Ids,',','],['),']') LIKE '%[{$_SESSION['login_Id']}]%' ";
					}
					$qry = $conn->query("SELECT * FROM project $where order by ProjectName asc");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($row['Description']),$trans);
						$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
					 	
					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td>
                            <p><b><?php echo ucwords($row['ProjectName']) ?></b></p>
                            <p class="truncate"><?php echo strip_tags($desc) ?></p>
                        </td>
                        <td><b><?php echo date("M d, Y",strtotime($row['StartDate'])) ?></b></td>
                        <td><b><?php echo date("M d, Y",strtotime($row['EndDate'])) ?></b></td>
                        <td class="text-center">
                            <?php
							  if($stat[$row['Status']] =='Pending'){
							  	echo "<span class='badge badge-secondary'>{$stat[$row['Status']]}</span>";
							  }
							  elseif($stat[$row['Status']] =='On-Progress'){
							  	echo "<span class='badge badge-info'>{$stat[$row['Status']]}</span>";}					 
							 elseif($stat[$row['Status']] =='Done'){
							  	echo "<span class='badge badge-success'>{$stat[$row['Status']]}</span>";
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
                                <a class="dropdown-item view_project"
                                    href="./index.php?page=view_project&Id=<?php echo $row['Id'] ?>"
                                    data-id="<?php echo $row['Id'] ?>">View</a>
                                <div class="dropdown-divider"></div>
                                <?php if($_SESSION['login_type'] != 2): ?>
                                <a class="dropdown-item"
                                    href="./index.php?page=update_project&Id=<?php echo $row['Id'] ?>">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_project" href="javascript:void(0)"
                                    data-id="<?php echo $row['Id'] ?>">Delete</a>
                                <?php endif; ?>
                            </div>
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


<!-- For Delete Project Action this Controller-->
<?php
 include '../controllers/ProjectController.php';
?>