<?php
// ===================================================================
// DAFTAR TUGAS DEFAULT (BISA DIEDIT LANGSUNG DI FILE INI)
// ===================================================================
$default_todos = [
    ['task' => 'Belajar PHP Dasar', 'completed' => true],
    ['task' => 'Membuat To-Do List dengan Array', 'completed' => true],
    ['task' => 'Menambahkan fitur simpan ke Session', 'completed' => false],
    ['task' => 'Memisahkan file fungsi dan tampilan', 'completed' => true],
    ['task' => 'Minum Kopi', 'completed' => false],
];

// Selalu mulai sesi di file logika
session_start();

// Inisialisasi daftar tugas dari array default JIKA sesi belum ada.
if (!isset($_SESSION['todos'])) {
    $_SESSION['todos'] = $default_todos;
}

// Menangani penambahan tugas baru (Method POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['new_todo']))) {
    $new_todo_text = htmlspecialchars(trim($_POST['new_todo']));
    $new_todo = ['task' => $new_todo_text, 'completed' => false];
    array_unshift($_SESSION['todos'], $new_todo);
    
    // Redirect untuk mencegah re-submit form
    header('Location: index.php');
    exit;
}

// Menangani aksi dari URL (Method GET)
if (isset($_GET['action'])) {
    $id = (int)$_GET['id'];

    // Aksi untuk menghapus tugas
    if ($_GET['action'] === 'delete') {
        if (isset($_SESSION['todos'][$id])) {
            unset($_SESSION['todos'][$id]);
            $_SESSION['todos'] = array_values($_SESSION['todos']);
        }
    }
    
    // Aksi untuk mengubah status (selesai/belum selesai)
    if ($_GET['action'] === 'toggle') {
        if (isset($_SESSION['todos'][$id])) {
            $_SESSION['todos'][$id]['completed'] = !$_SESSION['todos'][$id]['completed'];
        }
    }

    // Redirect kembali ke halaman utama setelah aksi
    header('Location: index.php');
    exit;
}