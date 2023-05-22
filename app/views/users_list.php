<?php 
 include '../../config/db_connect.php';
 include '../controllers/UserController.php';
?>

<link rel="stylesheet" href="../../assets/css/bootstrap.css">
<script src="../../assets/js/bootstrap.js"></script>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=user"><i
                        class="fa fa-plus"></i> Add New User</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table tabe-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$i = 1;//counter variable
					$type = array('',"Project Manager","Developer");
                    $Status=array('',"Available","On Leave");
					$qry = $conn->query("SELECT * FROM users order by `Name` asc");
					while($row= $qry->fetch_assoc()):
					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo ucwords($row['Name']) ?></b></td>
                        <td><b><?php echo $row['Email'] ?></b></td>
                        <td><b><?php echo $row['Address'] ?></b></td>
                        <td><b><?php echo $type[$row['type']] ?></b></td>
                        <td><b>
                                <?php 
                         if($Status[$row['Status']] =='Available'){
                            echo "<span class='badge badge-success'>{$Status[$row['Status']]}</span>";
                          }elseif($Status[$row['Status']] =='On Leave')
                            echo "<span class='badge badge-danger'>{$Status[$row['Status']]}</span>";
                            ?></b></td>

                        <td class="text-center">
                            <button type="button"
                                class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item view_user" href="javascript:void(0)"
                                    data-id="<?php echo $row['Id'] ?>">View</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                    href="./index.php?page=update_user&Id=<?php echo $row['Id'] ?>">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_user" href="javascript:void(0)"
                                    data-id="<?php echo $row['Id'] ?>">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>