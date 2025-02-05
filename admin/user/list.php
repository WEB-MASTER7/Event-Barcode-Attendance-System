<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
</script>
<?php endif; ?>
<div class="col-lg-12">
    <div class="card user-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">User Management</h3>
            <div class="card-tools">
                <a class="btn btn-primary new_user" href="javascript:void(0)">
                    <i class="fa fa-plus"></i> Add New
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered" id="list">
                <colgroup>
                    <col width="10%">
                    <col width="15%">
                    <col width="25%">
                    <col width="25%">
                    <col width="15%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $qry = $conn->query("SELECT *, concat(firstname, ' ', lastname) as name FROM `users` WHERE id != '{$_settings->userdata('id')}' ORDER BY concat(firstname, ' ', lastname) ASC ");
                    while ($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td class="text-center">
                            <img class="user-img" src="<?php echo validate_image($row['avatar']) ?>" alt="User Image">
                        </td>
                        <td><b><?php echo ucwords($row['name']) ?></b></td>
                        <td><b><?php echo $row['username'] ?></b></td>
                        <td><b><?php echo ($row['type'] == 1) ? "Admin" : "Registrar" ?></b></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_user">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn btn-danger btn-flat delete_user" data-id="<?php echo $row['id'] ?>">
                                    <i class="fas fa-trash"></i> Delete
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
    $('.new_user').click(function() {
        uni_modal("New User", "./user/manage.php", 'mid-large');
    });

    $('.manage_user').click(function() {
        uni_modal("Manage User", "./user/manage.php?id=" + $(this).attr('data-id'), 'mid-large');
    });

    $('.delete_user').click(function() {
        _conf("Are you sure to delete this User?", "delete_user", [$(this).attr('data-id')]);
    });

    $('#list').dataTable();
});

function delete_user(id) {
    start_loader();
    $.ajax({
        url: _base_url_ + 'classes/user.php?f=delete',
        method: 'POST',
        data: { id: id },
        success: function(resp) {
            if (resp == 1) {
                location.reload();
            }
        }
    });
}
</script>

<style>
/* Card and general UI styling */
.user-card {
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
    font-size: 1.25rem;
    font-weight: bold;
}

.card-body {
    padding: 20px;
}

/* Table styling */
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

/* Button styling */
.btn {
    font-size: 14px;
    font-weight: bold;
    padding: 10px 15px;
    border-radius: 6px;
    transition: background-color 0.3s ease;
}

.btn-primary {
    background-color: #4CAF50;
    border: none;
}

.btn-primary:hover {
    background-color: #45a049;
}

.btn-danger {
    background-color: #f44336;
    border: none;
}

.btn-danger:hover {
    background-color: #e53935;
}

.btn-flat {
    box-shadow: none;
    border: 1px solid transparent;
    transition: box-shadow 0.3s ease;
}

.btn-flat:hover {
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

/* User image styling */
.user-img {
    border-radius: 50%;
    width: 50px;
    height: 50px;
    object-fit: cover;
}

/* Badge styles */
.badge-warning {
    background-color: #ff9800;
    color: white;
}

.badge-info {
    background-color: #2196F3;
    color: white;
}

.badge-success {
    background-color: #4CAF50;
    color: white;
}

.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}
</style>
