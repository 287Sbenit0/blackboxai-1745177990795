<?php
// Create uploads directory if it doesn't exist
$uploadDir = __DIR__ . '/uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Create or open SQLite database
$db = new SQLite3(__DIR__ . '/photos.db');

// Create photos table if not exists
$db->exec("CREATE TABLE IF NOT EXISTS photos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    filename TEXT NOT NULL,
    upload_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Handle file upload
$uploadError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $file = $_FILES['photo'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($file['type'], $allowedTypes)) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newName = uniqid('img_', true) . '.' . $ext;
            $destination = $uploadDir . '/' . $newName;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                // Save filename to database
                $stmt = $db->prepare('INSERT INTO photos (filename) VALUES (:filename)');
                $stmt->bindValue(':filename', $newName, SQLITE3_TEXT);
                $stmt->execute();
            } else {
                $uploadError = 'Error moving uploaded file.';
            }
        } else {
            $uploadError = 'Invalid file type. Only JPG, PNG, and GIF allowed.';
        }
    } else {
        $uploadError = 'File upload error.';
    }
}

// Handle display photos button
$showPhotos = isset($_POST['show_photos']);
$photos = [];
if ($showPhotos) {
    $result = $db->query('SELECT filename FROM photos ORDER BY upload_time DESC');
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $photos[] = $row['filename'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir y Mostrar Fotos</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-roboto min-h-screen flex flex-col items-center p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Subir y Mostrar Fotos</h1>

    <form action="" method="POST" enctype="multipart/form-data" class="mb-6 w-full max-w-md bg-white p-6 rounded shadow">
        <label for="photo" class="block mb-2 font-semibold text-gray-700">Selecciona una foto para subir</label>
        <input type="file" name="photo" id="photo" accept="image/*" required class="mb-4 w-full border border-gray-300 rounded p-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            <i class="fas fa-upload mr-2"></i>Subir Foto
        </button>
        <?php if ($uploadError): ?>
            <p class="text-red-600 mt-2"><?php echo htmlspecialchars($uploadError); ?></p>
        <?php endif; ?>
    </form>

    <form action="" method="POST" class="mb-6">
        <button type="submit" name="show_photos" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            <i class="fas fa-images mr-2"></i>Mostrar Fotos
        </button>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full max-w-4xl">
        <?php if ($showPhotos): ?>
            <?php if (count($photos) === 0): ?>
                <p class="text-gray-600 col-span-full text-center">No hay fotos para mostrar.</p>
            <?php else: ?>
                <?php foreach ($photos as $photo): ?>
                    <div class="overflow-hidden rounded shadow-lg">
                        <img src="uploads/<?php echo htmlspecialchars($photo); ?>" alt="Foto subida" class="w-full h-auto object-cover">
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
