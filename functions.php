<?php

// Selalu mulai sesi di file
session_start();

// Inisialisasi daftar tugas dari array default JIKA sesi belum ada.
if (!isset($_SESSION['todos'])) {
    $_SESSION['todos'] = $default_todos;
}

// fungsi penambahan tugas baru (Method POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['new_todo']))) {
    $new_todo_text = htmlspecialchars(trim($_POST['new_todo']));
    $new_todo = ['task' => $new_todo_text, 'completed' => false];
    array_unshift($_SESSION['todos'], $new_todo);
    
    // Redirect agar tidak untuk mengulangi submit form
    header('Location: index.php');
    exit;
}

// fungsi dari URL (Method GET)
if (isset($_GET['action'])) {
    $id = (int)$_GET['id'];

    // fungsi untuk menghapus tugas
    if ($_GET['action'] === 'delete') {
        if (isset($_SESSION['todos'][$id])) {
            unset($_SESSION['todos'][$id]);
            $_SESSION['todos'] = array_values($_SESSION['todos']);
        }
    }
    
    // fungsi untuk mengubah status (selesai/belum selesai)
    if ($_GET['action'] === 'toggle') {
        if (isset($_SESSION['todos'][$id])) {
            $_SESSION['todos'][$id]['completed'] = !$_SESSION['todos'][$id]['completed'];
        }
    }

    // Redirect kembali ke halaman utama setelah fungsi
    header('Location: index.php');
    exit;
}