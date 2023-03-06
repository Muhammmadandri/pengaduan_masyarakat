<!DOCTYPE html>
<html>
<?php
session_start();
include('../../config/koneksi.php');
if (empty($_SESSION['username'])) {
    @header('location:../auth/index.php');
} else {
    $id_petugas = $_SESSION['id_petugas'];
    $username = $_SESSION['username'];
    $level = $_SESSION['level'];
}

if (isset($_POST['hapus'])) {
    $id_petugas = $_POST['id_petugas'];
    $q = mysqli_query($con, "DELETE FROM `petugas` WHERE id_petugas = '$id_petugas'");
}
if (isset($_POST['update'])) {
    $id_petugasLama = $_POST['id_petugasLama'];
    $id_petugas = $_POST['id_petugas'];
    $nama_petugas = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $telp = $_POST['telp'];
    $password = md5($_POST['password']);
    if ($password == '') {
        $q = mysqli_query($con, "UPDATE `petugas` SET id_petugas = '$id_petugas', nama_petugas = '$nama_petugas', username = '$username', telp = '$telp' WHERE id_petugas = '$id_petugasLama'");
    } else {
        $q = mysqli_query($con, "UPDATE `petugas` SET `password` = '$password', id_petugas = '$id_petugas', nama_petugas = '$nama_petugas', username = '$username', telp = '$telp' WHERE id_petugas = '$id_petugasLama'");
    }
}

?>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Aplikasi Pengaduan Masysrakat</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../../assets/img/icon.ico" type="image/x-icon"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<script src="../../assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../../assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/atlantis.min.css">
	<link href="../../assets/styles.css" rel="stylesheet" />
	<link href="../../assets/prism.css" rel="stylesheet" />
</head>
<body>
	<div class="wrapper">
		<div class="main-header">
			<div class="logo-header" data-background-color="light-blue2">
				<a href="index.html" class="logo">
					<img src="../../assets/img/logo.svg" alt="navbar brand" class="navbar-brand">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="light-blue2">
				<div class="container-fluid">
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						
					</ul>
				</div>
			</nav>
		</div>
		<div class="sidebar sidebar-style-2">
			<div class="sidebar-background"></div>
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<ul class="nav nav-info">
                    <?php if ($_SESSION['level'] == 'masyarakat') { ?>
						<li class="nav-item">
							<a href="dashboard.php">
								<i class="fas fa-user-circle"></i>
								<p>Profil</p>
							</a>
						</li>
                        <?php } ?>
						<li class="nav-item">
							<a href="pengaduan.php">
								<i class="fas fa-bullhorn"></i>
								<p>Pengaduan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="tanggapan.php">
								<i class="fas fa-flag"></i>
								<p>Respon</p>
							</a>
						</li>
                        <?php if ($_SESSION['level'] !== 'masyarakat') { ?>
						<li class="nav-item">
							<a href="masyarakat.php">
								<i class="fas fa-users"></i>
								<p>Masyarakat</p>
							</a>
						</li>
                        <?php } ?>
                        <?php if ($_SESSION['level'] !== 'masyarakat') { ?>
						<li class="nav-item active">
							<a href="petugas.php">
								<i class="fas fa-headset"></i>
								<p>Petugas</p>
							</a>
						</li>
                        <?php } ?>
						<li class="nav-item">
							<a href="../auth/logout.php">
								<i class="fas fa-door-open"></i>
								<p>Keluar</p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="main-panel">
			<div class="content content-documentation">
				<div class="container-fluid">
					<div class="card card-documentation">
						<div class="card-header bg-info-gradient text-white bubble-shadow">
							<h4>Atlantis || Pegawai</h4>
							<p class="mb-0 op-7">Daftar pegawai Atlantis</p>
						</div>
                        <div class="alert alert-success alert-dismissable">Selamat Datang <strong><?= $_SESSION['username'] ?></strong> anda Login Sebagai <strong><?= $_SESSION['level'] ?></strong> <a class="close" href="" data-dismiss="alert">x</a></div>
                        <div class="card-header">
                                <i class="fa fa-user-circle"></i><strong>Profil</strong>
                        </div>
                        <div class="card-body">
                            <div class="card col-md-auto">
                                <div class="card-header">ID Petugas : <?= $id_petugas ?></div>
                                <div class="card-header">Username : <?= $username ?></div>
                                <div class="card-header">Sebagai : <?= $level ?></div>
                            </div>
                            <table id="dataTablesNya" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Petugas</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Telp</th>
                                        <th>Update</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q = mysqli_query($con, "SELECT * FROM `petugas`");
                                    while ($d = mysqli_fetch_object($q)) { ?>
                                        <tr>
                                            <td><?= $d->id_petugas ?></td>
                                            <td><?= $d->nama_petugas ?></td>
                                            <td><?= $d->username ?></td>
                                            <td><?= $d->telp ?></td>
                                            <td><button data-toggle="modal" data-target="#modal-xl<?= $d->id_petugas ?>" class="btn btn-success"><i class="fa fa-pen"></i></button></td>
                                            <td>
                                                <form action="" method="post"><input type="hidden" name="id_petugas" value="<?= $d->id_petugas ?>"><button name="hapus" class="btn btn-danger"><i class="fa fa-trash"></i></button></form>
                                            </td>
                                        </tr>

                                        <!-- modal start -->
                                        <div class="modal fade" id="modal-xl<?= $d->id_petugas ?>">
                                            <div class="modal-dialog modal-xl<?= $d->id_petugas ?>">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Data</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="id_petugasLama" value="<?= $d->id_petugas ?>">
                                                        <div class="modal-body">
                                                            <div class="form-group"><label for="id_petugas">ID Petugas</label>
                                                                <input class="form-control" type="text" name="id_petugas" value="<?= $d->id_petugas ?>">
                                                            </div>
                                                            <div class="form-group"><label for="nama">Nama</label>
                                                                <input class="form-control" type="text" name="nama" value="<?= $d->nama_petugas ?>">
                                                            </div>
                                                            <div class="form-group"><label for="username">Username</label>
                                                                <input class="form-control" type="text" name="username" value="<?= $d->username ?>">
                                                            </div>
                                                            <div class="form-group"><label for="username">New Password</label>
                                                                <input class="form-control" type="password" name="password" value="">
                                                            </div>
                                                            <div class="form-group"><label for="username">Telepon</label>
                                                                <input class="form-control" type="number" name="telp" value="<?= $d->telp ?>">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                </div>
                                                </form>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- modal - ends -->

                                    <?php 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</body>
<script src="../../assets/js/core/jquery.3.2.1.min.js"></script>
<script src="../../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="../../assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
<script src="../../assets/js/core/popper.min.js"></script>
<script src="../../assets/js/core/bootstrap.min.js"></script>
<script src="../../assets/js/plugin/chart.js/chart.min.js"></script>
<script src="../../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="../../assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="../../assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
<script type="text/javascript" src="../../assets/js/plugin/jqvmap/maps/jquery.vmap.world.js" charset="utf-8"></script>
<script src="../../assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="../../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="../../assets/js/atlantis.min.js"></script>
<script src="../../assets/prism.js"></script>
<script src="../../assets/prism-normalize-whitespace.min.js"></script>
<script type="text/javascript">
	// Optional
	Prism.plugins.NormalizeWhitespace.setDefaults({
		'remove-trailing': true,
		'remove-indent': true,
		'left-trim': true,
		'right-trim': true,
	});
	
	// handle links with @href started with '#' only
	$(document).on('click', 'a[href^="#"]', function(e) {
		// target element id
		var id = $(this).attr('href');

		// target element
		var $id = $(id);
		if ($id.length === 0) {
			return;
		}

		// prevent standard hash navigation (avoid blinking in IE)
		e.preventDefault();

		// top position relative to the document
		var pos = $id.offset().top - 80;

		// animated top scrolling
		$('body, html').animate({scrollTop: pos});
	});
</script>
</html>