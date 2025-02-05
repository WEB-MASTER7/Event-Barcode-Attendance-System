<?php 
require_once('../../config.php');

if(isset($_GET['id']) && !empty($_GET['id'])){
    $qry = $conn->query("SELECT * FROM event_audience WHERE id = {$_GET['id']}");
    foreach($qry->fetch_array() as $k => $v){
        if(!is_numeric($k)){
            $$k = $v;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audience Form</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        form {
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
            font-size: 1.1em;
            color: #333;
        }

        input, textarea, select {
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            font-family: inherit;
            box-sizing: border-box;
            transition: all 0.3s ease-in-out;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        .btn-submit {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .form-control-sm {
            padding: 10px;
        }

        #msg {
            margin-bottom: 20px;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
</head>
<body>

<form action="" id="audience-frm">
    <div id="msg" class="form-group"></div>
    <input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
    
    <div class="form-group">
        <label for="name" class="control-label">Fullname</label>
        <input type="text" class="form-control form-control-sm" name="name" id="name" value="<?php echo isset($name) ? $name : '' ?>" required>
    </div>

    <div class="form-group">
        <label for="email" class="control-label">Email</label>
        <input type="email" class="form-control form-control-sm" name="email" id="email" value="<?php echo isset($email) ? $email : '' ?>" required>
    </div>

    <div class="form-group">
        <label for="contact" class="control-label">Contact</label>
        <input type="text" class="form-control form-control-sm" name="contact" id="contact" value="<?php echo isset($contact) ? $contact : '' ?>" required>
    </div>

    <div class="form-group">
        <label for="remarks" class="control-label">Remarks</label>
        <textarea type="text" class="form-control form-control-sm" name="remarks" id="remarks" required><?php echo isset($remarks) ? $remarks : '' ?></textarea>
    </div>

    <div class="form-group">
        <label for="event_id" class="control-label">Event</label>
        <select name="event_id" id="event_id" class="custom-select select2" required>
            <option></option>
            <?php 
                $qry = $conn->query("SELECT id, title FROM event_list ORDER BY CONCAT(title) ASC ");
                while($row = $qry->fetch_assoc()):
            ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($event_id) && $event_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['title']) ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <button type="submit" class="btn-submit">Submit</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2();
    
    // Validate name field to allow only letters
    $('#name').on('input', function() {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    });

    // Validate contact field to allow only numbers
    $('#contact').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#audience-frm').submit(function(e) {
        e.preventDefault();
        start_loader();
        if($('.err_msg').length > 0)
            $('.err_msg').remove();
        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=save_audience',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            dataType: 'json',
            error: function(err) {
                console.log(err);
                alert_toast("An error occurred", "error");
                end_loader();
            },
            success: function(resp) {
                if (resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                }
                end_loader();
            }
        });
    });
});
</script>

</body>
</html>
