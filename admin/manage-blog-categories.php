<?php
include 'inc/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'inc/header.php';
include 'inc/sidebar.php';

$categories = mysqli_query($conn, "
    SELECT c.*, p.name AS parent_name
    FROM blog_categories c
    LEFT JOIN blog_categories p ON c.parent_id = p.id
    ORDER BY c.id DESC
");

$parents = mysqli_query($conn, "SELECT id,name FROM blog_categories WHERE parent_id=0");
?>
<!-- DataTables -->
<link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manage Blog Categories</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <button class="btn btn-primary mb-3" id="addBtn">Add Category</button>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($row = mysqli_fetch_assoc($categories)): ?>
                                <tr id="row_<?php echo $row['id']; ?>">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo $row['parent_name'] ?? '-'; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info editBtn"
                                            data-id="<?php echo $row['id']; ?>"
                                            data-name="<?php echo htmlspecialchars($row['name']); ?>"
                                            data-parent="<?php echo $row['parent_id']; ?>">
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
<div class="modal fade" id="categoryModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="categoryForm">
                <div class="modal-header">
                    <h5 class="modal-title">Category</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="cat_id">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Parent Category</label>
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value="0">None</option>
                            <?php while ($p = mysqli_fetch_assoc($parents)): ?>
                                <option value="<?php echo $p['id']; ?>">
                                    <?php echo htmlspecialchars($p['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
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
    $('#addBtn').click(function() {
        $('#categoryForm')[0].reset();
        $('#cat_id').val('');
        $('#categoryModal').modal('show');
    });

    /* EDIT */
    $('.editBtn').click(function() {
        $('#cat_id').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        $('#parent_id').val($(this).data('parent'));
        $('#categoryModal').modal('show');
    });

    /* SAVE */
    $('#categoryForm').submit(function(e) {
        e.preventDefault();
        let data = $(this).serialize() + '&action=save';

        $.post('process_blog_categories.php', data, function(res) {
            if (res.status === 'success') {
                Swal.fire('Success', res.message, 'success')
                    .then(() => location.reload());
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }, 'json');
    });

    /* DELETE */
    $('.deleteBtn').click(function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Delete?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33'
        }).then((r) => {
            if (r.isConfirmed) {
                $.post('process_blog_categories.php', {
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