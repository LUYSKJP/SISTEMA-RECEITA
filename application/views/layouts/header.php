<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Receitas & Rotulagem ANVISA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/css/app.css'); ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo site_url('recipes'); ?>">Receitas & Rotulagem</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?php echo site_url('recipes'); ?>">Receitas</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo site_url('ingredients'); ?>">Ingredientes</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo site_url('config-anvisa'); ?>">Config ANVISA</a></li>
            </ul>
            <a class="btn btn-outline-light" href="<?php echo site_url('logout'); ?>">Sair</a>
        </div>
    </div>
</nav>
<div class="container">
