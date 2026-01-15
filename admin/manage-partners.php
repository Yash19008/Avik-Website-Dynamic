<?php
include 'inc/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'inc/header.php';
include 'inc/sidebar.php';

$partners = mysqli_query($conn, "SELECT * FROM partners ORDER BY id DESC");
?>

<!-- DataTables -->
<link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manage Partners</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <button class="btn btn-primary mb-3" id="addPartnerBtn">
                Add Partner
            </button>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Logo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($row = mysqli_fetch_assoc($partners)): ?>
                                <tr id="row_<?php echo $row['id']; ?>">
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                        <img src="uploads/partners/<?php echo $row['image']; ?>" width="120">
                                    </td>
                                    <td>
                                        <button
                                            class="btn btn-sm btn-info editBtn"
                                            data-id="<?php echo $row['id']; ?>"
                                            data-image="<?php echo $row['image']; ?>">
                                            Edit
                                        </button>

                                        <button
                                            class="btn btn-sm btn-danger deleteBtn"
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
<div class="modal fade" id="partnerModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="partnerForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Partner</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="partner_id">
                    <input type="hidden" name="old_image" id="old_image">

                    <div class="form-group">
                        <label>Partner Logo</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div class="form-group">
                        <img id="previewImage" src="" style="max-width:150px; display:none;">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    /* ADD */
    $('#addPartnerBtn').click(function() {
        $('#partnerForm')[0].reset();
        $('#partner_id').val('');
        $('#old_image').val('');
        $('#previewImage').hide();
        $('#partnerModal').modal('show');
    });

    /* EDIT */
    $('.editBtn').click(function() {
        let id = $(this).data('id');
        let image = $(this).data('image');

        $('#partner_id').val(id);
        $('#old_image').val(image);
        $('#previewImage').attr('src', 'uploads/partners/' + image).show();
        $('#partnerModal').modal('show');
    });

    /* IMAGE PREVIEW */
    $('#image').change(function() {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#previewImage').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(this.files[0]);
    });

    /* SAVE (ADD + EDIT) */
    $('#partnerForm').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        formData.append('action', 'save');

        $.ajax({
            url: 'process_partners.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire('Success', res.message, 'success')
                        .then(() => location.reload());
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Server error occurred', 'error');
            }
        });
    });

    /* DELETE */
    $('.deleteBtn').click(function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('process_partners.php', {
                    action: 'delete',
                    delete_id: id
                }, function(res) {
                    if (res.status === 'success') {
                        $('#row_' + id).remove();
                        Swal.fire('Deleted', res.message, 'success');
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                }, 'json');
            }
        });
    });
</script>