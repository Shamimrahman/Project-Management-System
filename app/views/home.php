<?php include '../../config/db_connect.php' ?>

<?php
$twhere ="";
if($_SESSION['login_type'] != 1)
  $twhere = "  ";
?>
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
      $where = " where concat('[',REPLACE(User_Ids,',','],['),']') LIKE '%[{$_SESSION['login_Id']}]%' ";
    }
     $where2 = "";
    if($_SESSION['login_type'] == 1){
      $where2 = " where p.Manager_Id = '{$_SESSION['login_Id']}' ";
    }elseif($_SESSION['login_type'] == 2){
      $where2 = " where concat('[',REPLACE(p.User_Ids,',','],['),']') LIKE '%[{$_SESSION['login_Id']}]%' ";
    }
    ?>

<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-success">
            <div class="card-header">
                <b>Project Progress</b>
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
                            <th>Progress</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php
                $i = 1;
                $stat = array("Pending","Started","On-Progress","On-Hold","Over Due","Done");
                $where = "";
                if($_SESSION['login_type'] == 1){
                  $where = " where Manager_Id = '{$_SESSION['login_Id']}' ";
                }elseif($_SESSION['login_type'] == 2){
                  $where = " where concat('[',REPLACE(User_Ids,',','],['),']') LIKE '%[{$_SESSION['login_Id']}]%' ";
                }
                $qry = $conn->query("SELECT * FROM project $where order by ProjectName asc");
                while($row= $qry->fetch_assoc()):
                  $prog= 0;
                $tprog = $conn->query("SELECT * FROM task where Project_Id = {$row['Id']}")->num_rows;
                $cprog = $conn->query("SELECT * FROM task where Project_Id = {$row['Id']} and Status = 3")->num_rows;
                $prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
                $prog = $prog > 0 ?  number_format($prog,2) : $prog;
                $prod = $conn->query("SELECT * FROM users where Name = {$row['Id']}")->num_rows;
                if($row['Status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['StartDate'])):
                if($prod  > 0  || $cprog > 0)
                  $row['Status'] = 2;
                else
                  $row['Status'] = 1;
                elseif($row['Status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['EndDate'])):
                $row['Status'] = 4;
                endif;
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
                                <td class="project_progress">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57"
                                            aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                                        </div>
                                    </div>
                                    <small>
                                        <?php echo $prog ?>% Complete
                                    </small>
                                </td>
                                <td class="project-state">
                                    <?php
                            if($stat[$row['Status']] =='Pending'){
                              echo "<span class='badge badge-secondary'>{$stat[$row['Status']]}</span>";
                            }elseif($stat[$row['Status']] =='Started'){
                              echo "<span class='badge badge-primary'>{$stat[$row['Status']]}</span>";
                            }elseif($stat[$row['Status']] =='On-Progress'){
                              echo "<span class='badge badge-info'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['Status']] =='On-Hold'){
                              echo "<span class='badge badge-warning'>{$stat[$row['Status']]}</span>";
                            }elseif($stat[$row['Status']] =='Over Due'){
                              echo "<span class='badge badge-danger'>{$stat[$row['Status']]}</span>";
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