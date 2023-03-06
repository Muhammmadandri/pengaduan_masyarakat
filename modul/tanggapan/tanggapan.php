<?php
// SESSION
session_start();
include('../../config/koneksi.php');
if (empty($_SESSION['username'])) {
    @header('location:../auth/index.php');
} else {
    if ($_SESSION['level'] == 'masyarakat') {
        $nik = $_SESSION['nik'];
    } else {
        $id_petugas = $_SESSION['id_petugas'];
    }
}
// tambah tanggapan
if (isset($_POST['tambah_tanggapan'])) {
    $id_pengaduan = $_POST['id_pengaduan'];
    $tgl_tanggapan = $_POST['tgl_tanggapan'];
    $id_petugas = $_POST['id_petugas'];
    $tanggapan = $_POST['tanggapan'];
    $q = "INSERT INTO `tanggapan` (id_tanggapan, id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) VALUES ('','$id_pengaduan', '$tgl_tanggapan', '$tanggapan', '$id_petugas')";
    $r = mysqli_query($con, $q);
}
// hapus tanggapan
if (isset($_POST['hapusTanggapan'])) {
    $id_tanggapan = $_POST['id_tanggapan'];
    mysqli_query($con, "DELETE FROM `tanggapan` WHERE id_tanggapan = '$id_tanggapan'");
}
// update tanggapan
if (isset($_POST['ubahTanggapan'])) {
    $id_tanggapan =  $_POST['id_tanggapan'];
    $tgl_tanggapan = $_POST['tgl_tanggapan'];
    $tanggapan = $_POST['tanggapan'];
    mysqli_query($con, "UPDATE `tanggapan` SET tgl_tanggapan = '$tgl_tanggapan', tanggapan = '$tanggapan' WHERE `id_tanggapan` = '$id_tanggapan'");
}
?>
<!DOCTYPE html>
<html>
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
						<li class="nav-item active">
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
						<li class="nav-item">
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
							<h4>Atlantis || Respon</h4>
							<p class="mb-0 op-7">Kami akan merespon aduan Anda disini</p>
						</div>
                        <div class="card-header">
                        <?php if ($_SESSION['level'] !== 'masyarakat') { ?>
                            <div class="col-sm-3" style="padding:0.5%;">
                                <button data-toggle="modal" data-target="#modal-lg" class="btn btn-success"><i class="fa fa-pen"></i>&nbsp;tambah tanggapan</button>
                            </div>
                        <?php } ?>
                            <!-- modal start -->
                            <div class="modal fade" id="modal-lg">
                                <div class="modal-dialog modal-lg">          
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            Tambah Tanggapan
                                        </div>
                                    
                                        <div class="modal-body">
                                            <form action="" method="post">
                                                <label for="id_pengaduan"> Pilih Id Pengaduan</label>
                                                <select name="id_pengaduan" class="form-control">
                                                    <?php
                                                    $q = "SELECT * FROM pengaduan JOIN `masyarakat` WHERE pengaduan.nik = masyarakat.nik";
                                                    $r = mysqli_query($con, $q);
                                                    while ($d = mysqli_fetch_object($r)) { ?>
                                                        <option value="<?= $d->id_pengaduan ?>"><?= $d->id_pengaduan . '|' . $d->nik . '|' . $d->nama ?></option>
                                                    <?php } ?>
                                                </select>
                                                <br>
                                                <label for="tgl_tanggapan">Tanggal</label>
                                                <input class="form-control" type="date" name="tgl_tanggapan">
                                                <label for="tanggapan">Beri Tanggapan</label>
                                                <textarea class="form-control" name="tanggapan" id="" cols="30" rows="10"></textarea>
                                                <label for="id_petugas">ID Petugas</label>
                                                <input name="id_petugas" type="text" class="form-control" value="<?= $id_petugas ?>" readonly>
                                                <br>
                                                <button name="tambah_tanggapan" type="submit" class="btn btn-info">simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                            <!-- modal ends -->
                        </div>
                        <div class="card-body">
                            <table id="dataTablesNya" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Id Pengaduan</th>
                                        <th>tanggal Tanggapan</th>
                                        <th>Isi Tanggapan</th>
                                        <th>Petugas</th>
                                        <th>hapus</th>
                                        <th>edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $q = "SELECT * FROM `tanggapan` JOIN `petugas` JOIN `pengaduan`
                                WHERE tanggapan.id_petugas = petugas.id_petugas 
                                AND tanggapan.id_pengaduan = pengaduan.id_pengaduan";
                                    $r = mysqli_query($con, $q);
                                    while ($d = mysqli_fetch_object($r)) { ?>
                                        <tr>
                                            <td>
                                                <?= $no ?>
                                            </td>
                                            <td>
                                                <?= $d->id_pengaduan ?>
                                            </td>
                                            <td>
                                                <?= $d->tgl_tanggapan ?>
                                            </td>
                                            <td>
                                                <?= $d->tanggapan ?>
                                            </td>
                                            <td>
                                                <?= $d->id_petugas ?>
                                            </td>
                                            <td>
                                                <?php if ($_SESSION['level'] != 'masyarakat') { ?>
                                                    <form action="" method="post"><input type="hidden" name="id_tanggapan" value="<?= $d->id_tanggapan ?>"><button name="hapusTanggapan" class="btn btn-danger" type="submit"><i class="fa fa-trash"></i>&nbsp;hapus</button></form>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($_SESSION['level'] != 'masyarakat') { ?>
                                                    <button class="btn btn-success" data-toggle="modal" data-target="#modal-lg<?= $d->id_pengaduan ?>" class="btn btn-success"><i class="fa fa-pen"></i>&nbsp;Edit</button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="modal-lg<?= $d->id_pengaduan ?>">
                                            <div class="modal-dialog modal-lg<?= $d->id_pengaduan ?>">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        Edit Pengaduan
                                                    </div>
                                                    <form action="" method="post">
                                                        <div class="modal-body">
                                                            <input class="form-control" name="id_tanggapan" type="hidden" value="<?= $d->id_tanggapan ?>">
                                                            <label for="id_pengaduan">ID Pengaduan</label><br>
                                                            <select class="form-control" name="id_pengaduan">
                                                                <?php
                                                                $result = mysqli_query($con, "SELECT * FROM `pengaduan` JOIN `masyarakat` WHERE pengaduan.nik = masyarakat.nik");
                                                                while ($data = mysqli_fetch_object($result)) { ?>
                                                                    <option value="<?= $data->id_pengaduan ?>" <?php if ($d->id_pengaduan == $data->id_pengaduan) {
                                                                                                                    echo 'selected';
                                                                                                                } ?>><?= $data->id_pengaduan . '|' . $data->nik . '|' . $data->nama ?></option>
                                                                <?php } ?>
                                                            </select><br>
                                                            <label for="tgl_tanggapan">Tanggal Tanggapan</label>
                                                            <input class="form-control" name="tgl_tanggapan" class="form-control" type="date" name="" value="<?= $d->tgl_tanggapan ?>">
                                                            <label for="tanggapan">Tanggapan</label>
                                                            <textarea class="form-control" name="tanggapan" id="" cols="30" rows="10"><?= $d->tanggapan ?></textarea>
                                                            <br>
                                                            <button name="ubahTanggapan" type="submit" class="btn btn-info">Update</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    <?php $no++;
                                    } ?>
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