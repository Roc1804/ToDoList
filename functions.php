<?php

session_start();

$default_todos = [

];

if (!isset($_SESSION['todos'])) {
    $_SESSION['todos'] = $default_todos;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_todo'])) {
    $new_todo_text = htmlspecialchars(trim($_POST['new_todo']));
    if (!empty($new_todo_text)) {
        $new_todo = ['task' => $new_todo_text, 'completed' => false];
        array_unshift($_SESSION['todos'], $new_todo);
    }
    
    // Redirect agar tidak mengulangi submit form
    header('Location: index.php');
    exit;
}

// --- Handler untuk Form Edit Tugas (Method POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_todo_id']) && isset($_POST['edited_task'])) {
    $id = (int)$_POST['edit_todo_id'];
    $edited_task_text = htmlspecialchars(trim($_POST['edited_task']));

    if (isset($_SESSION['todos'][$id]) && !empty($edited_task_text)) {
        $_SESSION['todos'][$id]['task'] = $edited_task_text;
    }
    
    // Redirect kembali ke halaman utama setelah update
    header('Location: index.php');
    exit;
}


// --- Handler untuk Aksi dari URL (Method GET: delete, toggle) ---
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // fungsi untuk menghapus tugas
    if ($_GET['action'] === 'delete') {
        if (isset($_SESSION['todos'][$id])) {
            unset($_SESSION['todos'][$id]);
            $_SESSION['todos'] = array_values($_SESSION['todos']); // Re-index array
        }
    }
    
    // fungsi untuk mengubah status (selesai/belum selesai)
    if ($_GET['action'] === 'toggle') {
        if (isset($_SESSION['todos'][$id])) {
            $_SESSION['todos'][$id]['completed'] = !$_SESSION['todos'][$id]['completed'];
        }
    }

    // Redirect kembali ke halaman utama setelah aksi
    header('Location: index.php');
    exit;
}

// Variabel untuk menyimpan ID tugas yang sedang diedit dan teksnya
$edit_id = -1;
$edit_task_text = '';

if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    if (isset($_SESSION['todos'][$edit_id])) {
        $edit_task_text = $_SESSION['todos'][$edit_id]['task'];
    } else {
        $edit_id = -1;
    }
}
?>