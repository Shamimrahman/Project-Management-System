<?php include '../../config/db_connect.php' ?>

<!-- Info boxes -->
<div class="col-12">
    <div class="card">
        <div class="card-body">
            Welcome <?php echo $_SESSION['login_Name'] ?>
        </div>
    </div>
</div>
<hr>
<?php 

    $where = "";
    if($_SESSION['login_type'] == 1){
      $where = " where Manager_Id = '{$_SESSION['login_Id']}' ";
    }elseif($_SESSION['login_type'] == 2){
      $where = " where concat('[',REPLACE(Developer_Ids,',','],['),']') LIKE '%[{$_SESSION['login_Id']}]%' ";
    }
    
    ?>

<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-success">
            <div class="card-header">
                <b>Project Dashboard</b>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0 table-hover">
                        <colgroup>
                            <col width="5%">
                            <col width="30%">
                            <col width="35%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <th>#</th>
                            <th>Project</th>
                            <th>Proj Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php
                $i = 1;
                $stat = array("Pending","On-Progress","Done");
                $where = "";
                if($_SESSION['login_type'] == 1){
                  $where = " where Manager_Id = '{$_SESSION['login_Id']}' ";
                }elseif($_SESSION['login_type'] == 2){
                  $where = " where concat('[',REPLACE(Developer_Ids,',','],['),']') LIKE '%[{$_SESSION['login_Id']}]%' ";
                }
                $qry = $conn->query("SELECT * FROM project $where order by ProjectName asc");
                while($row= $qry->fetch_assoc()):
               
                  ?>
                            <tr>
                                <td>
                                    <?php echo $i++ ?>
                                </td>
                                <td>
                                    <a>
                                        <?php echo ucwords($row['ProjectName']) ?>
                                    </a>
                                    <br>
                                    <small>
                                        Due: <?php echo date("Y-m-d",strtotime($row['EndDate'])) ?>
                                    </small>
                                </td>

                                <td class="project-state">
                                    <?php
                            if($stat[$row['Status']] =='Pending'){
                              echo "<span class='badge badge-secondary'>{$stat[$row['Status']]}</span>";
                            
                            }elseif($stat[$row['Status']] =='On-Progress'){
                              echo "<span class='badge badge-info'>{$stat[$row['Status']]}</span>";
                            }elseif($stat[$row['Status']] =='Done'){
                              echo "<span class='badge badge-success'>{$stat[$row['Status']]}</span>";
                            }
                          ?>
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-sm"
                                        href="./index.php?page=view_project&Id=<?php echo $row['Id'] ?>">
                                        <i class="fas fa-folder">
                                        </i>
                                        View
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-12">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM project $where")->num_rows; ?></h3>
                        <p>Total Projects</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-layer-group"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-12">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT t.*,p.Id as pid FROM task t inner join project p on p.Id = t.Project_Id $where")->num_rows; ?>
                            <p>Total Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tasks"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>