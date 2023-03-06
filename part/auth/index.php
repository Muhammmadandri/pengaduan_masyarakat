<?php
include('../../config/koneksi.php');
if (isset($_POST['cek'])) {
    $pilihan = $_POST['pilihan']; //masyarakat atau petugas
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    if ($pilihan == 'masyarakat') {
        $q = mysqli_query($con, "SELECT * FROM `masyarakat` WHERE username = '$username' AND password = '$password' AND verifikasi = 1");
        $r = mysqli_num_rows($q);
        if ($r == 1) {
            $d = mysqli_fetch_object($q);
            @session_start();
            $_SESSION['nik'] = $d->nik;
            $_SESSION['username'] = $d->username;
            $_SESSION['nama'] = $d->nama;
            $_SESSION['telp'] = $d->telp;
            $_SESSION['level'] = 'masyarakat';
            @header('location:../dashboard/dashboard.php');
        } else {
            echo '<div class="alert alert-danger alert-dismissable"><a href="" class="close" data-dismiss="alert">x</a> <strong class="text-white">Data salah atau belum di verifikasi</strong></div>';
        }
    } else if ($pilihan == 'petugas') {
        $q = mysqli_query($con, "SELECT * FROM `petugas` WHERE username = '$username' AND password = '$password'");
        $r = mysqli_num_rows($q);
        if ($r == 1) {
            $d = mysqli_fetch_object($q);
            @session_start();
            $_SESSION['username'] = $d->username;
            $_SESSION['level'] = $d->level;
            $_SESSION['id_petugas'] = $d->id_petugas;
            @header('location:../dashboard/petugas.php');
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>PENMASAT</title>
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
        <!-- Content Wrapper. Contains page content -->
        <!-- Main content -->
        <section class="content ">
            <div class="container-fluid">
                <div class="row justify-content-md-center">
                    <div class="col-md-3" style="margin-top:5%">
                        <!-- jquery validation -->
                        <div class="card">
                            <div class="card-header card-primary">
                                <h3 class="card-title"><i class="fa fa-users">&nbsp;</i>Login <small>PENMASAT</small></h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Username</label>
                                        <input type="text" name="username" class="form-control" placeholder="Masukan Username">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Masukan Password">
                                    </div>
                                    <label for="pilihan">.:LOGIN SEBAGAI:.</label>
                                    <div class="form-group">
                                        <select class="form-control" name="pilihan">
                                            <option value="masyarakat">Masyarakat</option>
                                            <option value="petugas">Petugas</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-0">
                                        <span class="text text-success">Belum terverifikasi?</span>Coba daftar <a href="registrasi.php">disini</a>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="form-group">
                                        <button name="cek" type="submit" class="form-control btn btn-primary">Masuk</button>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.container-fluid -->
        <!-- /.content -->
        <!-- /.content-wrapper -->
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