<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('admin.home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('admin.home'));
});

// Home > Ruangan
Breadcrumbs::for('admin.ruangan', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Ruangan', route('admin.ruangan.index'));
});

// Home > Ruangan > Buat Ruangan
Breadcrumbs::for('admin.ruangan.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.ruangan');
    $trail->push('Buat Ruangan', route('admin.ruangan.create'));
});


// Home > Ruangan > [Ruangan]
Breadcrumbs::for('admin.ruangan.edit', function (BreadcrumbTrail $trail, $ruangan) {
    $trail->parent('admin.ruangan');
    $trail->push($ruangan->nama, route('admin.ruangan.edit', $ruangan));
});

// Peminjaman Ruangan
Breadcrumbs::for('admin.peminjaman.ruangan', function (BreadcrumbTrail $trail) {
    $trail->push('Peminjaman Ruangan', route('admin.peminjaman.ruangan.index'));
});

// Peminjaman Ruangan > [Nomor Surat]
Breadcrumbs::for('admin.peminjaman.ruangan.show', function (BreadcrumbTrail $trail, $borrow) {
    $trail->parent('admin.peminjaman.ruangan');
    $trail->push($borrow->nomor_surat, route('admin.peminjaman.ruangan.show', $borrow->id));
});
