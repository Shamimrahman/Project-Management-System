<?php include '../../config/db_connect.php' ?>
<div class="col-md-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <b>Project Progress Report</b>
            <div class="card-tools">
                <button class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i
                        class="fa fa-print"></i> Print</button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" id="printable">
                <table class="table m-0 table-bordered">
                    <!--  <colgroup>
                  <col width="5%">
                  <col width="30%">
                  <col width="35%">
                  <col width="15%">
                  <col width="15%">
                </colgroup> -->
                    <thead>
                        <th>#</th>
                        <th>Project</th>
                        <th>Task</th>
                        <th>Completed Task</th>
                        <th>Work Duration</th>
                        <th>Status</th>
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
                $tprog = $conn->query("SELECT * FROM task where Project_Id = {$row['Id']}")->num_rows;
                $cprog = $conn->query("SELECT * FROM task where Project_Id = {$row['Id']} and Status = 3")->num_rows;
                $prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
                $prog = $prog > 0 ?  number_format($prog,2) : $prog;
                
               
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
                            <td class="text-center">
                                <?php echo number_format($tprog) ?>
                            </td>
                            <td class="text-center">
                                <?php echo number_format($cprog) ?>
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
                              echo "<span class='badge badge-info'>{$stat[$row['Status']]}</span>";
                            }elseif($stat[$row['Status']] =='On-Hold'){
                              echo "<span class='badge badge-warning'>{$stat[$row['Status']]}</span>";
                            }elseif($stat[$row['Status']] =='Over Due'){
                              echo "<span class='badge badge-danger'>{$stat[$row['Status']]}</span>";
                            }elseif($stat[$row['Status']] =='Done'){
                              echo "<span class='badge badge-success'>{$stat[$row['Status']]}</span>";
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
</div>
<script>
$('#print').click(function() {
    start_load()
    var _h = $('head').clone()
    var _p = $('#printable').clone()
    var _d = "<p class='text-center'><b>Project Progress Report as of (<?php echo date("F d, Y") ?>)</b></p>"
    _p.prepend(_d)
    _p.prepend(_h)
    var nw = window.open("", "", "width=900,height=600")
    nw.document.write(_p.html())
    nw.document.close()
    nw.print()
    setTimeout(function() {
        nw.close()
        end_load()
    }, 750)
})
</script>