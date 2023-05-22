<?php 
 include '../../config/db_connect.php';
if(isset($_GET['Id'])){
	$qry = $conn->query("SELECT * FROM task where Id = ".$_GET['Id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v; //dynamic Variable
	}

}
?>
<div class="container-fluid">
    <form action="" id="manage-task">
        <input type="hidden" name="Id" value="<?php echo isset($Id) ? $Id : '' ?>">
        <input type="hidden" name="Project_Id" value="<?php echo isset($_GET['Id']) ? $_GET['Id'] : '' ?>">
        <div class="form-group">
            <label for="">Task</label>
            <input type="text" class="form-control form-control-sm" name="Title"
                value="<?php echo isset($Title) ? $Title : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <textarea name="Description" id="" cols="30" rows="10" class="summernote form-control">
				<?php echo isset($Description) ? $Description : '' ?>
			</textarea>
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
        <div class="form-group">
            <label for="">Estimated Hours</label>
            <input type="text" class="form-control form-control-sm" name="EstimatedHour"
                value="<?php echo isset($EstimatedHour) ? $EstimatedHour: '' ?>" required>
        </div>
        <div class="form-group">
            <label for="">Status</label>
            <select name="Status" id="Status" class="custom-select custom-select-sm">
                <option value="1" <?php echo isset($Status) && $Status == 1 ? 'selected' : '' ?>>Pending</option>
                <option value="2" <?php echo isset($Status) && $Status == 2 ? 'selected' : '' ?>>On-Progress</option>
                <option value="3" <?php echo isset($Status) && $Status == 3 ? 'selected' : '' ?>>Done</option>
            </select>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {


    $('.summernote').summernote({
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript',
                'clear'
            ]],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ol', 'ul', 'paragraph', 'height']],
            ['table', ['table']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
        ]
    })
})
</script>

<?php
 include '../controllers/task/create_task.php';
?>