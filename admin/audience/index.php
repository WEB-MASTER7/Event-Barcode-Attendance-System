<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
?>

<?php if ($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>

<div class="col-lg-12">
    <div class="card audience-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Audience Management</h3>
            <div class="card-tools">
                <a class="btn btn-primary new_audience" href="javascript:void(0)">
                    <i class="fa fa-plus"></i> Add New Audience
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Event</th>
                        <th>Name</th>
                        <th>Details</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $qry = $conn->query("SELECT a.*, e.title FROM event_audience a INNER JOIN event_list e ON e.id = a.event_id ORDER BY a.name ASC");
                    while ($row = $qry->fetch_assoc()): ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo ucwords($row['title']) ?></b></td>
                        <td>
                            <b><?php echo ucwords($row['name']) ?></b> 
                            <span><a href="javascript:void(0)" class="view_data" data-id="<?php echo $row['id'] ?>"><span class="fa fa-qrcode"></span></a></span>
                        </td>
                        <td>
                            <small><b>Email:</b> <?php echo $row['email'] ?></small><br>
                            <small><b>Contact:</b> <?php echo $row['contact'] ?></small>
                        </td>
                        <td><b><?php echo ($row['remarks']) ?></b></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-success btn-flat manage_audience">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-flat delete_audience" data-id="<?php echo $row['id'] ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.new_audience').click(function() {
        uni_modal("New Audience", "/event/admin/audience/manage.php");
    });

    $('.manage_audience').click(function(){
        uni_modal("Manage Audience","./audience/manage.php?id="+$(this).attr('data-id'));
    });

    $('.view_data').click(function(){
        uni_modal("QR","./audience/view.php?id="+$(this).attr('data-id'));
    });

    $('.delete_audience').click(function(){
        _conf("Are you sure to delete this audience?", "delete_audience", [$(this).attr('data-id')]);
    });

    $('#list').dataTable();

    function delete_audience($id){
        start_loader();
        $.ajax({
            url: _base_url_+'classes/Master.php?f=delete_audience',
            method: 'POST',
            data: {id: $id},
            dataType: "json",
            error: function(err){
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp){
                if(resp.status == 'success'){
                    location.reload();
                } else {
                    alert_toast("Deleting Data Failed", 'error');
                }
                end_loader();
            }
        });
    }
});
</script>

<style>
/* Card Styling */
.audience-card {
    border: 1px solid #e9ecef;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    margin-bottom: 30px;
}

.card-header {
    background-color: #007bff;
    color: white;
    padding: 15px;
    border-radius: 12px 12px 0 0;
}

.card-title {
    font-size: 1.5rem;
    font-weight: bold;
}

/* Button Styling */
.new_audience {
    background-color: #007bff;
    color: white;
    border-radius: 50px;
    padding: 10px 15px;
    transition: background-color 0.3s ease;
}

.new_audience:hover {
    background-color: #0056b3;
}

/* Table Styling */
.table-hover tbody tr:hover {
    background-color: #f9f9f9;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #dee2e6;
    padding: 12px;
    text-align: center;
}

thead th {
    background-color: #007bff;
    color: white;
}

/* Button group styling */
.btn-group .btn-flat {
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn-success {
    background-color: #28a745;
    color: white;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-success:hover {
    background-color: #218838;
}

.btn-danger:hover {
    background-color: #c82333;
}

</style>
