<?php
include 'inc/db.php';
include 'inc/header.php';
include 'inc/sidebar.php';

$id = (int)($_GET['id'] ?? 0);
$data = [
    'title' => '',
    'slug' => '',
    'date' => '',
    'time' => '',
    'content' => '',
    'info' => '',
    'speaker_name' => '',
    'speaker_desg' => '',
    'speaker_desc' => '',
    'speaker_image' => '',
    'speaker_socials' => '[]'
];

if ($id) {
    $res = mysqli_query($conn, "SELECT * FROM events WHERE id=$id");
    $data = mysqli_fetch_assoc($res);
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1><?php echo $id ? 'Edit' : 'Add'; ?> Event</h1>
        </div>
    </section>

    <section class="content">
        <form id="eventForm" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="old_image" value="<?php echo $data['speaker_image']; ?>">
            <input type="hidden" name="removed_images" id="removed_images">
            <input type="hidden" name="speaker_socials" id="speaker_socials">

            <!-- EVENT DETAILS -->
            <div class="card">
                <div class="card-header"><h5>Event Details</h5></div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" id="title"
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($data['title']); ?>" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" name="slug" id="slug"
                                       class="form-control"
                                       value="<?php echo $data['slug']; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label>Date</label>
                            <input type="text" name="date" class="form-control" value="<?php echo $data['date']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Time</label>
                            <input type="text" name="time" class="form-control" value="<?php echo $data['time']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Info</label>
                            <input type="text" name="info" class="form-control"
                                   value="<?php echo htmlspecialchars($data['info']); ?>">
                        </div>
                    </div>

                </div>
            </div>

            <!-- EVENT IMAGES -->
            <div class="card">
                <div class="card-header"><h5>Event Images</h5></div>
                <div class="card-body">

                    <input type="file" name="images[]" class="form-control mb-3" multiple>

                    <?php
                    $imgs = json_decode($data['images'] ?? '[]', true);
                    if ($imgs):
                    ?>
                        <div class="row">
                            <?php foreach ($imgs as $img): ?>
                                <div class="col-md-2 text-center mb-3">
                                    <img src="<?php echo $img; ?>" class="img-fluid rounded mb-1">
                                    <button type="button"
                                            class="btn btn-danger btn-sm removeImage"
                                            data-img="<?php echo $img; ?>">
                                        Remove
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- EVENT CONTENT -->
            <div class="card">
                <div class="card-header"><h5>Event Content</h5></div>
                <div class="card-body">
                    <textarea name="content" id="content" class="form-control">
                        <?php echo $data['content']; ?>
                    </textarea>
                </div>
            </div>

            <!-- SPEAKER DETAILS -->
            <div class="card">
                <div class="card-header"><h5>Speaker Details</h5></div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <input class="form-control mb-2"
                                   name="speaker_name"
                                   placeholder="Speaker Name"
                                   value="<?php echo $data['speaker_name']; ?>">
                        </div>
                        <div class="col-md-4">
                            <input class="form-control mb-2"
                                   name="speaker_desg"
                                   placeholder="Designation"
                                   value="<?php echo $data['speaker_desg']; ?>">
                        </div>
                        <div class="col-md-4">
                            <input type="file" name="speaker_image" class="form-control mb-2">
                        </div>
                    </div>

                    <?php if ($data['speaker_image']): ?>
                        <img src="<?php echo $data['speaker_image']; ?>" width="120" class="rounded mb-3">
                    <?php endif; ?>

                    <textarea class="form-control"
                              name="speaker_desc"
                              placeholder="Speaker Description"><?php echo $data['speaker_desc']; ?></textarea>

                </div>
            </div>

            <!-- SPEAKER SOCIALS -->
            <div class="card">
                <div class="card-header"><h5>Speaker Socials</h5></div>
                <div class="card-body">

                    <table class="table table-bordered" id="socialTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Link</th>
                                <th width="50"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <button type="button" class="btn btn-secondary btn-sm" id="addSocial">
                        Add Social
                    </button>

                </div>
            </div>

            <!-- SAVE -->
            <div class="text-right mb-4">
                <button class="btn btn-success btn-lg px-5">Save Event</button>
            </div>

        </form>
    </section>
</div>

<?php include 'inc/footer.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#content').summernote({
        height: 250
    });

    /* slug */
    $('#title').keyup(function() {
        $('#slug').val($(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, ''));
    });

    /* socials */
    let socials = <?php
    echo json_encode(
        $data['speaker_socials']
            ? json_decode($data['speaker_socials'], true)
            : []
    );
    ?>;

    function renderSocials() {
        let html = '';
        socials.forEach((s, i) => {
            html += `
            <tr>
                <td>
                    <input class="form-control social-name" data-i="${i}" value="${s.name || ''}">
                </td>
                <td>
                    <input class="form-control social-link" data-i="${i}" value="${s.link || ''}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm removeSocial" data-i="${i}">X</button>
                </td>
            </tr>`;
        });
    
        $('#socialTable tbody').html(html);
        $('#speaker_socials').val(JSON.stringify(socials));
    }

    renderSocials();

    $('#addSocial').click(() => {
        socials.push({
            name: '',
            link: ''
        });
        renderSocials();
    });

    /* save */
    $('#eventForm').submit(function(e) {
        e.preventDefault();
        let fd = new FormData(this);
        fd.append('action', 'save');

        $.ajax({
            url: 'process_events.php',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: r => {
                if (r.status == 'success') {
                    Swal.fire('Saved', '', 'success').then(() => location.href = 'manage-events.php');
                } else Swal.fire('Error', r.message, 'error');
            }
        });
    });

    let removedImages = [];

    $('.removeImage').click(function() {
        let img = $(this).data('img');
        removedImages.push(img);
        $('#removed_images').val(JSON.stringify(removedImages));
        $(this).parent().remove();
    });
    
    $(document).on('input', '.social-name', function () {
        socials[$(this).data('i')].name = this.value;
        $('#speaker_socials').val(JSON.stringify(socials));
    });
    
    $(document).on('input', '.social-link', function () {
        socials[$(this).data('i')].link = this.value;
        $('#speaker_socials').val(JSON.stringify(socials));
    });
    
    $(document).on('click', '.removeSocial', function () {
        socials.splice($(this).data('i'), 1);
        renderSocials();
    });

</script>