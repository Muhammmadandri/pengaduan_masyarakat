<?php
// SESSION
session_start();
include('../../config/koneksi.php');
if (empty($_SESSION['username'])) {
    @header('location:../auth/index.php');
} else {
    if ($_SESSION['level'] == 'masyarakat') {
        $nik = $_SESSION['nik'];
    }
}
// CRUD
if (isset($_POST['tambahPengaduan'])) {
    $isi_laporan = $_POST['isi_laporan'];
    $tgl = $_POST['tgl_pengaduan'];
    //upload
    $ekstensi_diperbolehkan = array('jpg', 'png');
    $foto = $_FILES['foto']['name'];
    print_r($foto);
    $x = explode(".", $foto);
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['foto']['tmp_name'];
    if (!empty($foto)) {
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            $q = "INSERT INTO `pengaduan`(id_pengaduan, tgl_pengaduan, nik, isi_laporan, foto, `status`) VALUES ('', '$tgl', '$nik', '$isi_laporan', '$foto', '0')";
            $r = mysqli_query($con, $q);
            if ($r) {
                move_uploaded_file($file_tmp, '../../assets/img/masyarakat/' . $foto);
            }
        }
    } else {
        $q = "INSERT INTO `pengaduan`(id_pengaduan, tgl_pengaduan, nik, isi_laporan, foto, `status`) VALUES ('', '$tgl', '$nik', '$isi_laporan', '', '0')";
        $r = mysqli_query($con, $q);
    }
}

// hapus pengaduan
if (isset($_POST['hapus'])) {
    $id_pengaduan = $_POST['id_pengaduan'];
    if ($id_pengaduan != '') {
        $q = "SELECT `foto` FROM `pengaduan` WHERE id_pengaduan = $id_pengaduan";
        $r = mysqli_query($con, $q);
        $d = mysqli_fetch_object($r);
        unlink('../../assets/img/masyarakat/' . $d->foto);
    }
    $q = "DELETE FROM `pengaduan` WHERE id_pengaduan = $id_pengaduan";
    $r = mysqli_query($con, $q);
}

// rubah status pengaduan
if (isset($_POST['proses_pengaduan'])) {
    $id_pengaduan = $_POST['id_pengaduan'];
    $status = $_POST['status'];
    $q = "UPDATE `pengaduan` SET status = '$status' WHERE id_pengaduan = '$id_pengaduan'";
    $r = mysqli_query($con, $q);
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
						<li class="nav-item active">
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
							<h4>Atlantis || Pengaduan</h4>
							<p class="mb-0 op-7">Silahkan kirim aduan Anda ke Atlantis | Kami akan merespon secepat mungkin</p>
						</div>
                        <div class="card-body">
                        <?php if ($_SESSION['level'] == 'masyarakat') { ?>

                        <div class="card">
                            <div class="card-header">
                                <button data-toggle="modal" data-target="#modal-lg" class="btn btn-success">buat pengaduan&nbsp;<i class="fa fa-pen"></i></button>
                            </div>
                        </div>

                        <?php } ?>
                        <div class="modal fade" id="modal-lg">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    Buat Pengaduan
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="nik" value="">
                                        <div class="form-group">
                                            <label for="isi_laporan">Isi Laporan</label>
                                            <textarea name="isi_laporan" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="tgl_pengaduan">Tanggal Pengaduan</label>
                                            <input type="date" name="tgl_pengaduan" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="foto">Foto</label>
                                            <input type="file" name="foto" class="form-control">
                                        </div>
                                        <input type="submit" name="tambahPengaduan" value="simpan" class="btn btn-success">
                                    </form>
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </div>
                        </div>
                        <table id="dataTablesNya" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Nik</th>
                                    <th>Isi Laporan</th>
                                    <th>Foto</th>
                                    <th>Status</th>
                                    <th>hapus</th>
                                    <th>proses Pengaduan</th>
                                </tr>
                            </thead>
                            <?php  ?>
                            <tbody>
                                <?php
                                if ($_SESSION['level'] == 'masyarakat') {
                                    $q = "SELECT * FROM `pengaduan` WHERE `nik` = $nik";
                                } else {
                                    $q = "SELECT * FROM `pengaduan`";
                                }
                                $r = mysqli_query($con, $q);
                                $no = 1;
                                while ($d = mysqli_fetch_object($r)) {
                                ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $d->tgl_pengaduan ?></td>
                                        <td><?= $d->nik ?></td>
                                        <td><?= $d->isi_laporan ?></td>
                                        <td><?php if ($d->foto == '') {
                                                echo '<img style="max-height:100px" class="img img-thumbnail" src="../../assets/img/no-foto.png">';
                                            } else {
                                                echo '<img style="max-height:100px" class="img img-thumbnail" src="../../assets/img/masyarakat/' . $d->foto . '">';
                                            } ?></td>
                                        <td><?= $d->status ?></td>
                                        <td>
                                            <?php if ($_SESSION['level'] == 'masyarakat') { ?>
                                                <form action="" method="post"><input type="hidden" name="id_pengaduan" value="<?= $d->id_pengaduan ?>"><button type="submit" name="hapus" class="btn btn-danger"><i class="fa fa-trash"></i></button></form>
                                            <?php } ?>
                                        </td>
                                        <td><?php if ($_SESSION['level'] !== 'masyarakat') { ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="id_pengaduan" value="<?= $d->id_pengaduan ?>">
                                                <select class="form-control" name="status">
                                                    <option value="0"> 0 </option>
                                                    <option value="proses"> proses </option>
                                                    <option value="selesai"> selesai </option>
                                                </select><br>
                                                <button type="submit" name="proses_pengaduan" class="btn btn-success form-control">ubah</button>
                                            </form>
                                            <?php } ?>
                                        </td>
                                    </tr>
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