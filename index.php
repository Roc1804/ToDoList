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
        <h1 class="text-center mb-4">Daftar Tugas</h1>

        <?php if ($edit_id === -1): ?>
            <form action="index.php" method="POST" class="mb-4">
                <div class="input-group">
                    <input type="text" name="new_todo" class="form-control" placeholder="Tambahkan tugas baru..." required autocomplete="off">
                    <button class="btn btn-primary" type="submit">Tambah</button>
                </div>
            </form>
        <?php else: ?>
            <h2 class="mt-4 mb-3">Edit Tugas</h2>
            <form action="index.php" method="POST" class="mb-4">
                <input type="hidden" name="edit_todo_id" value="<?php echo $edit_id; ?>">
                <div class="input-group">
                    <input type="text" name="edited_task" class="form-control" value="<?php echo htmlspecialchars($edit_task_text); ?>" required autocomplete="off">
                    <button class="btn btn-success" type="submit">Update</button>
                    <a href="index.php" class="btn btn-secondary ms-2">Batal</a>
                </div>
            </form>
        <?php endif; ?>
        
        <?php if (!empty($_SESSION['todos'])): ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 5%;"></th> <th style="width: 5%;">No.</th>
                        <th style="width: 45%;">Tugas</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 30%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['todos'] as $index => $todo): ?>
                        <tr>
                            <td>
                                <a href="index.php?action=toggle&id=<?php echo $index; ?>" class="text-decoration-none">
                                    <?php echo $todo['completed'] ? '☑' : '☐'; ?>
                                </a>
                            </td>
                            <td><?php echo $index + 1; ?></td>
                            <td>
                                <span class="task-text <?php echo $todo['completed'] ? 'completed text-muted' : ''; ?>">
                                    <?php echo htmlspecialchars($todo['task']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($todo['completed']): ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Belum Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!$todo['completed']): ?>
                                    <a class="btn btn-outline-success btn-sm me-1" href="index.php?action=toggle&id=<?php echo $index; ?>">Selesai</a>
                                <?php endif; ?>
                                <a class="btn btn-outline-warning btn-sm me-1" href="index.php?edit_id=<?php echo $index; ?>">Edit</a>
                                <a class="btn btn-outline-danger btn-sm" href="index.php?action=delete&id=<?php echo $index; ?>">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty-message alert alert-info mt-4">Daftar tugas kosong....</p>
        <?php endif; ?>
        
    </div>

</body>
</html>