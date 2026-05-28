<?php
// =====================================================
// FILE: views/partials/header.php
// FUNGSI: Header untuk halaman dashboard
// =====================================================
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'SIRT' ?> - Sistem Informasi Rukun Tetangga</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: #f5f6fa;
    }

    .dashboard-container {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 280px;
        background: #2c3e50;
        color: white;
        padding: 20px;
        position: fixed;
        height: 100vh;
        overflow-y: auto;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #34495e;
    }

    .sidebar nav a {
        display: block;
        padding: 12px 15px;
        color: #ecf0f1;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 5px;
        transition: all 0.3s ease;
    }

    .sidebar nav a:hover {
        background: #34495e;
    }

    .sidebar nav a.active {
        background: #667eea;
    }

    .main-content {
        flex: 1;
        margin-left: 280px;
        padding: 20px;
    }

    .top-bar {
        background: white;
        padding: 15px 25px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .content-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .user-info {
        text-align: right;
    }

    .user-info span {
        font-weight: 600;
        display: block;
    }

    .user-info small {
        color: #7f8c8d;
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 250px;
        }

        .main-content {
            margin-left: 250px;
        }
    }
    </style>
</head>

<body>