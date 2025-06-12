<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

</head>
<body>

    <div class="container">
        <h1>To-Do List</h1>

        <form action="index.php" method="POST">
            <input type="text" name="new_todo" placeholder="Tambahkan tugas baru..." required autocomplete="off">
            <button class="btn btn-primary" type="submit">Tambah</button>
        </form>

        <?php if (!empty($_SESSION['todos'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Checkbox</th>
                        <th>No.</th>
                        <th>Tugas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['todos'] as $index => $todo): ?>
                        <tr>
                            <td>
                                <a href="index.php?action=toggle&id=<?php echo $index; ?>">
                                    <?php echo $todo['completed'] ? '☑' : '☐'; ?>
                                </a>
                            </td>
                            <td><?php echo $index + 1; ?></td>
                            <td>
                                <span class="task-text <?php echo $todo['completed'] ? 'completed' : ''; ?>">
                                    <?php echo htmlspecialchars($todo['task']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($todo['completed']): ?>
                                    <span class="status status-completed">Selesai</span>
                                <?php else: ?>
                                    <span class="status status-pending">Belum Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!$todo['completed']): ?>
                                    <a class="btn btn-outline-success" href="index.php?action=toggle&id=<?php echo $index; ?>" style="margin-right: 10px;">Selesai</a>
                                <?php endif; ?>
                                <a class="btn btn-outline-danger" href="index.php?action=delete&id=<?php echo $index; ?>">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty-message">Daftar tugas kosong.</p>
        <?php endif; ?>
        
    </div>

</body>
</html>