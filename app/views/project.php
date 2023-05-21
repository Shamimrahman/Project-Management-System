<?php if(!isset($conn)){ include '../../config/db_connect.php';} ?>

<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-project">

                <input type="hidden" name="Id" value="<?php echo isset($Id) ? $Id : '' ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Name</label>
                            <input type="text" class="form-control form-control-sm" name="ProjectName"
                                value="<?php echo isset($ProjectName) ? $ProjectName : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" id="Status" class="custom-select custom-select-sm">
                                <option value="0" <?php echo isset($Status) && $Status == 0 ? 'selected' : '' ?>>Pending
                                </option>
                                <option value="5" <?php echo isset($Status) && $Status == 5 ? 'selected' : '' ?>>On-Hold
                                </option>
                                <option value="10" <?php echo isset($Status) && $Status == 10 ? 'selected' : '' ?>>Done
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Start Date</label>
                            <input type="date" class="form-control form-control-sm" autocomplete="off" name="StartDate"
                                value="<?php echo isset($StartDate) ? date("Y-m-d",strtotime($StartDate)) : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">End Date</label>
                            <input type="date" class="form-control form-control-sm" autocomplete="off" name="EndDate"
                                value="<?php echo isset($EndDate) ? date("Y-m-d",strtotime($EndDate)) : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php if($_SESSION['login_type'] == 2 ): ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Project Manager</label>
                            <select class="form-control form-control-sm select2" name="Manager_Id">
                                <option></option>
                                <?php 
              	$managers = $conn->query("SELECT * FROM users where type = 1");
              	while($row= $managers->fetch_assoc()):
              	?>
                                <option value="<?php echo $row['Id'] ?>"
                                    <?php echo isset($Manager_Id) && $Manager_Id == $row['Id'] ? "selected" : '' ?>>
                                    <?php echo ucwords($row['Name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <?php else: ?>
                    <input type="hidden" name="Manager_Id" value="<?php echo $_SESSION['login_Id'] ?>">
                    <?php endif; ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Developers Team</label>
                            <select class="form-control form-control-sm select2" multiple="multiple" name="User_Ids[]">
                                <option></option>
                                <?php 
              	$developers = $conn->query("SELECT *FROM users where type = 2");
              	while($row= $developers ->fetch_assoc()):
              	?>
                                <option value="<?php echo $row['Id'] ?>"
                                    <?php echo isset($User_Ids) && in_array($row['Id'],explode(',',$User_Ids)) ? "selected" : '' ?>>
                                    <?php echo ucwords($row['Name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="" class="control-label">Description</label>
                            <textarea name="Description" id="" cols="30" rows="10" class="summernote form-control">
						<?php echo isset($Description) ? $Description : '' ?>
					</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer border-top border-info">
            <div class="d-flex w-100 justify-content-center align-items-center">
                <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-project">Save</button>
                <button class="btn btn-flat bg-gradient-secondary mx-2" type="button"
                    onclick="location.href='index.php?page=projects_list'">Cancel</button>
            </div>
        </div>
    </div>
</div>

<?php
 include '../controllers/project/create_project.php';
?>