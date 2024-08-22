<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PENGHOETANK</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Kelola penghutang dengan mudah menggunakan aplikasi PENGHOETANK. Pantau status hutang dan kelola data penghutang secara efisien.">
    <meta name="keywords" content="kelola penghutang, aplikasi hutang, manajemen hutang, PENGHOETANK, catat hutang, reminder hutang">
    <meta name="author" content="RafieDotID">
    <meta property="og:title" content="Kelola Penghutang - PENGHOETANK">
    <meta property="og:description" content="Kelola penghutang dengan mudah menggunakan aplikasi PENGHOETANK. Pantau status hutang dan kelola data penghutang secara efisien.">
    <meta property="og:image" content="URL-to-your-image.jpg">
    <meta property="og:url" content="URL-of-your-page">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Favicon -->
    <link rel="icon" href="icons/icon.png" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css">
    <style>
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
            table thead {
                display: none;
            }
            table tbody tr {
                display: block;
                margin-bottom: 15px;
            }
            table tbody tr td {
                display: block;
                text-align: right;
                font-size: 13px;
                border-bottom: 1px solid #ddd;
            }
            table tbody tr td::before {
                content: attr(data-label);
                float: left;
                text-transform: uppercase;
                font-weight: bold;
            }
            table tbody tr td:last-child {
                border-bottom: 0;
            }
        }
        .badge-success {
            background-color: #28a745; /* Hijau untuk status Lunas */
            color: #fff;
        }

        .badge-danger {
            background-color: #dc3545; /* Merah untuk status Belum Lunas */
            color: #fff;
        }
    </style>
</head>
