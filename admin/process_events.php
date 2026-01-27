<?php
declare(strict_types=1);

include 'inc/db.php';
header('Content-Type: application/json');

/* ================= CONFIG ================= */
$uploadDir = 'uploads/events/';
$allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
$allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
$maxSize = 5 * 1024 * 1024;

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

/* ================= HELPERS ================= */
function clean(string $v): string
{
    return trim(htmlspecialchars($v, ENT_QUOTES, 'UTF-8'));
}

function slugify(string $text): string
{
    return strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $text), '-'));
}

function safeDelete(?string $file, string $dir): void
{
    if (!$file) return;
    $path = $dir . basename($file);
    if (file_exists($path)) unlink($path);
}

function uploadImage(array $file, string $dir, array $exts, array $mimes, int $max): ?string
{
    if ($file['error'] !== UPLOAD_ERR_OK) return null;
    if ($file['size'] > $max) return null;

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $mime = mime_content_type($file['tmp_name']);

    if (!in_array($ext, $exts) || !in_array($mime, $mimes)) {
        return null;
    }

    $name = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $path = $dir . $name;

    return move_uploaded_file($file['tmp_name'], $path) ? $path : null;
}

/* ================= ACTION ================= */
$action = $_POST['action'] ?? '';
if (!in_array($action, ['save', 'delete'], true)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    exit;
}

/* =========================================================
   ========================= SAVE ===========================
   ========================================================= */
if ($action === 'save') {
    try {
        $id = (int)($_POST['id'] ?? 0);

        /* BASIC DATA */
        $title = clean($_POST['title'] ?? '');
        if (!$title) throw new Exception('Title required');

        $slug = clean($_POST['slug'] ?? '');
        $slug = $slug ?: slugify($title);

        $date = clean($_POST['date'] ?? '');
        $time = clean($_POST['time'] ?? '');
        $info = clean($_POST['info'] ?? '');
        $content = $_POST['content'] ?? '';

        /* SPEAKER */
        $speaker_name = clean($_POST['speaker_name'] ?? '');
        $speaker_desg = clean($_POST['speaker_desg'] ?? '');
        $speaker_desc = clean($_POST['speaker_desc'] ?? '');
        $speakerImage = $_POST['old_image'] ?? '';

        /* SOCIALS (RAW JSON – DO NOT ESCAPE) */
        $socials = $_POST['speaker_socials'] ?? '[]';
        json_decode($socials);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid speaker socials');
        }

        /* SLUG UNIQUE CHECK */
        $chk = $conn->prepare("SELECT id FROM events WHERE slug=? AND id!=?");
        $chk->bind_param('si', $slug, $id);
        $chk->execute();
        $chk->store_result();
        if ($chk->num_rows > 0) {
            throw new Exception('Slug already exists');
        }
        $chk->close();

        /* SPEAKER IMAGE UPLOAD */
        if (!empty($_FILES['speaker_image']['name'])) {
            $img = uploadImage($_FILES['speaker_image'], $uploadDir, $allowedExt, $allowedMime, $maxSize);
            if ($img) {
                safeDelete($speakerImage, $uploadDir);
                $speakerImage = $img;
            }
        }

        /* EXISTING EVENT IMAGES */
        $existingImages = [];
        if ($id > 0) {
            $q = $conn->prepare("SELECT images FROM events WHERE id=?");
            $q->bind_param('i', $id);
            $q->execute();
            $q->bind_result($imgJson);
            if ($q->fetch()) {
                $existingImages = json_decode($imgJson ?? '[]', true) ?: [];
            }
            $q->close();
        }

        /* REMOVED IMAGES */
        $removed = json_decode($_POST['removed_images'] ?? '[]', true);
        if (is_array($removed)) {
            foreach ($removed as $rm) {
                safeDelete($rm, $uploadDir);
                $existingImages = array_values(array_diff($existingImages, [$rm]));
            }
        }

        /* NEW IMAGE UPLOADS */
        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['name'] as $i => $n) {
                if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) continue;

                $file = [
                    'name' => $_FILES['images']['name'][$i],
                    'tmp_name' => $_FILES['images']['tmp_name'][$i],
                    'error' => $_FILES['images']['error'][$i],
                    'size' => $_FILES['images']['size'][$i]
                ];

                $img = uploadImage($file, $uploadDir, $allowedExt, $allowedMime, $maxSize);
                if ($img) $existingImages[] = $img;
            }
        }

        $imagesJson = json_encode(array_values($existingImages));

        /* INSERT / UPDATE */
        if ($id === 0) {
            $stmt = $conn->prepare("
                INSERT INTO events
                (title, slug, date, time, info, content,
                 speaker_name, speaker_desg, speaker_desc,
                 speaker_image, speaker_socials, images)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
            ");
            $stmt->bind_param(
                'ssssssssssss',
                $title,
                $slug,
                $date,
                $time,
                $info,
                $content,
                $speaker_name,
                $speaker_desg,
                $speaker_desc,
                $speakerImage,
                $socials,
                $imagesJson
            );
        } else {
            $stmt = $conn->prepare("
                UPDATE events SET
                title=?, slug=?, date=?, time=?, info=?, content=?,
                speaker_name=?, speaker_desg=?, speaker_desc=?,
                speaker_image=?, speaker_socials=?, images=?
                WHERE id=?
            ");
            $stmt->bind_param(
                'ssssssssssssi',
                $title,
                $slug,
                $date,
                $time,
                $info,
                $content,
                $speaker_name,
                $speaker_desg,
                $speaker_desc,
                $speakerImage,
                $socials,
                $imagesJson,
                $id
            );
        }

        $stmt->execute();
        $stmt->close();

        echo json_encode(['status' => 'success']);
    } catch (Throwable $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

/* =========================================================
   ======================== DELETE ==========================
   ========================================================= */
if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);

    $stmt = $conn->prepare("SELECT images, speaker_image FROM events WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($imgsJson, $speakerImg);

    if ($stmt->fetch()) {
        $imgs = json_decode($imgsJson ?? '[]', true) ?: [];
        foreach ($imgs as $img) safeDelete($img, $uploadDir);
        safeDelete($speakerImg, $uploadDir);
    }
    $stmt->close();

    $del = $conn->prepare("DELETE FROM events WHERE id=?");
    $del->bind_param('i', $id);
    $del->execute();
    $del->close();

    echo json_encode(['status' => 'success']);
}