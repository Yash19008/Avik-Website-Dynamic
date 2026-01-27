<?php
include 'inc/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'inc/header.php';
include 'inc/sidebar.php';

$works = mysqli_query($conn, "SELECT * FROM works ORDER BY id DESC");
?>

<!-- DataTables -->
<link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manage Works</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <button class="btn btn-primary mb-3" id="addWorkBtn">Add Work</button>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="worksTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Image</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while ($row = mysqli_fetch_assoc($works)): ?>
                                <tr id="row_<?php echo $row['id']; ?>">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                                    <td>
                                        <img src="<?php echo $row['image']; ?>" width="120">
                                    </td>
                                    <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info editBtn"
                                            data-id="<?php echo $row['id']; ?>"
                                            data-name="<?php echo htmlspecialchars($row['name']); ?>"
                                            data-location="<?php echo htmlspecialchars($row['location']); ?>"
                                            data-image="<?php echo $row['image']; ?>">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger deleteBtn"
                                            data-id="<?php echo $row['id']; ?>">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- MODAL -->
<div class="modal fade" id="workModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="workForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Work</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="work_id">
                    <input type="hidden" name="old_image" id="old_image">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" id="location" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" accept="image/*" id="image" class="form-control">
                    </div>

                    <div id="preview"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>

<!-- DataTables  & Plugins -->
<script src="./plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="./plugins/jszip/jszip.min.js"></script>
<script src="./plugins/pdfmake/pdfmake.min.js"></script>
<script src="./plugins/pdfmake/vfs_fonts.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {
    $('#worksTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});

/* ADD */
$('#addWorkBtn').click(function () {
    $('#workForm')[0].reset();
    $('#work_id,#old_image').val('');
    $('#preview').html('');
    $('#workModal').modal('show');
});

/* EDIT */
$('.editBtn').click(function () {
    $('#work_id').val($(this).data('id'));
    $('#name').val($(this).data('name'));
    $('#location').val($(this).data('location'));
    $('#old_image').val($(this).data('image'));
    $('#preview').html(`<img src="${$(this).data('image')}" width="150">`);
    $('#workModal').modal('show');
});

/* IMAGE PREVIEW */
$('#image').change(function () {
    let reader = new FileReader();
    reader.onload = e => $('#preview').html(`<img src="${e.target.result}" width="150">`);
    reader.readAsDataURL(this.files[0]);
});

/* SAVE */
$('#workForm').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('action', 'save');

    $.ajax({
        url: 'process_works.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success') {
                Swal.fire('Success', res.message, 'success')
                    .then(() => location.reload());
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }
    });
});

/* DELETE */
$('.deleteBtn').click(function () {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Delete this work?',
        icon: 'warning',
        showCancelButton: true
    }).then(result => {
        if (result.isConfirmed) {
            $.post('process_works.php', {
                action: 'delete',
                id: id
            }, function (res) {
                if (res.status === 'success') {
                    $('#row_' + id).remove();
                    Swal.fire('Deleted!', '', 'success');
                }
            }, 'json');
        }
    });
});
</script>