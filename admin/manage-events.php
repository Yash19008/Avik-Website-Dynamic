<?php
include 'inc/db.php';
include 'inc/header.php';
include 'inc/sidebar.php';

$events = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");
?>

<!-- DataTables -->
<link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manage Events</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <a href="add-event.php" class="btn btn-primary mb-3">Add Event</a>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Slug</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($row = mysqli_fetch_assoc($events)): ?>
                                <tr id="row_<?php echo $row['id']; ?>">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td><?php echo $row['date']; ?></td>
                                    <td><?php echo $row['time']; ?></td>
                                    <td><?php echo $row['slug']; ?></td>
                                    <td>
                                        <a href="add-event.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                                        <button class="btn btn-sm btn-danger deleteBtn" data-id="<?php echo $row['id']; ?>">Delete</button>
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

    $('.deleteBtn').click(function() {
        let id = $(this).data('id');
        Swal.fire({
                title: 'Delete?',
                showCancelButton: true
            })
            .then(r => {
                if (r.isConfirmed) {
                    $.post('process_events.php', {
                        action: 'delete',
                        id: id
                    }, res => {
                        if (res.status == 'success') {
                            $('#row_' + id).remove();
                            Swal.fire('Deleted', '', 'success');
                        }
                    }, 'json');
                }
            });
    });
</script>