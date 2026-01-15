<?php
include 'inc/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'inc/header.php';
include 'inc/sidebar.php';

$gallery = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
?>

<!-- DataTables -->
<link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manage Gallery</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <button class="btn btn-primary mb-3" id="addGalleryBtn">Add Gallery Item</button>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Preview</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($row = mysqli_fetch_assoc($gallery)): ?>
                                <tr id="row_<?php echo $row['id']; ?>">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo ucfirst($row['type']); ?></td>
                                    <td>
                                        <?php if ($row['type'] == 'image'): ?>
                                            <img src="<?php echo $row['link']; ?>" width="120">
                                        <?php else: ?>
                                            <video width="150" controls>
                                                <source src="<?php echo $row['link']; ?>">
                                            </video>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info editBtn"
                                            data-id="<?php echo $row['id']; ?>"
                                            data-type="<?php echo $row['type']; ?>"
                                            data-link="<?php echo $row['link']; ?>">
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
<div class="modal fade" id="galleryModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="galleryForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Gallery Item</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="gallery_id">
                    <input type="hidden" name="old_link" id="old_link">

                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="">Select</option>
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Upload File</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>OR Direct Link</label>
                        <input type="url" name="link" id="link" class="form-control">
                    </div>

                    <div class="form-group">
                        <div id="preview"></div>
                    </div>
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
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    
    /* ADD */
    $('#addGalleryBtn').click(function() {
        $('#galleryForm')[0].reset();
        $('#gallery_id,#old_link').val('');
        $('#preview').html('');
        $('#galleryModal').modal('show');
    });

    /* EDIT */
    $('.editBtn').click(function() {
        $('#gallery_id').val($(this).data('id'));
        $('#type').val($(this).data('type'));
        $('#old_link').val($(this).data('link'));
        $('#link').val($(this).data('link'));

        previewContent($(this).data('type'), $(this).data('link'));
        $('#galleryModal').modal('show');
    });

    /* FILE PREVIEW */
    $('#file').change(function() {
        let file = this.files[0];
        let type = $('#type').val();
        let reader = new FileReader();

        reader.onload = function(e) {
            previewContent(type, e.target.result);
        }
        reader.readAsDataURL(file);
    });

    /* LINK PREVIEW */
    $('#link').on('input', function() {
        previewContent($('#type').val(), $(this).val());
    });

    /* PREVIEW FUNCTION */
    function previewContent(type, src) {
        if (type === 'image') {
            $('#preview').html(`<img src="${src}" style="max-width:150px;">`);
        } else if (type === 'video') {
            $('#preview').html(`
            <video width="200" controls>
                <source src="${src}">
            </video>
        `);
        }
    }

    /* SAVE */
    $('#galleryForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('action', 'save');

        $.ajax({
            url: 'process_gallery.php',
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
            }
        });
    });

    /* DELETE */
    $('.deleteBtn').click(function() {
        let id = $(this).data('id');
        Swal.fire({
                title: 'Delete?',
                icon: 'warning',
                showCancelButton: true
            })
            .then((r) => {
                if (r.isConfirmed) {
                    $.post('process_gallery.php', {
                        action: 'delete',
                        delete_id: id
                    }, function(res) {
                        if (res.status === 'success') {
                            $('#row_' + id).remove();
                            Swal.fire('Deleted', '', 'success');
                        }
                    }, 'json');
                }
            });
    });
</script>