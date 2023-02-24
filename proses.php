 <?php session_start();
 include "koneksi_db.php";
 
//Create

if(isset($_POST['add'])){
	$namafile = $_FILES['gambar']['name'];
	$sizefile = $_FILES['gambar']['size'];
	$errorfile = $_FILES['gambar']['error'];
	$tmpfile = $_FILES['gambar']['tmp_name'];
	
	$check = mysqli_query($koneksi, "select nik from data_warga where nik = '".$_POST['nik']."'");
	if(mysqli_num_rows($check) > 0){
		$_SESSION['konfirm'] = false;
		$_SESSION['warning'] = "The \"Nik\" data don't be same with the other \"Nik\" data!!";
	}
	else{
		$foto = verify_file($namafile, $sizefile, $errorfile, $tmpfile, NULL, $koneksi);
		$foto = explode("=", $foto);
		$foto = end($foto);
		mysqli_query($koneksi, "insert into data_warga values(
		'".$_POST['nik']."', 
		'".$_POST['nama']."', 
		'".$_POST['alamat']."',
		'".$_POST['pekerjaan']."',
		'".$_POST['ttl']."/".$_POST['ttl2']."',
		'".$_POST['agama']."',
		'".$_POST['telepon']."',
		'".$_POST['email']."', 
		".$foto.")");
		if(mysqli_affected_rows($koneksi) > 0){
			$_SESSION['konfirm'] = true;
		}
		else{
			$_SESSION['konfirm'] = false;
		}
	}
	$_SESSION['message'] = "Add data!!";
	header("location:daftar_warga.php");
}

//Update

if(isset($_POST['edit'])){
	function edit($koneksi){
		
		$namafile = $_FILES['gambar']['name'];
		$sizefile = $_FILES['gambar']['size'];
		$errorfile = $_FILES['gambar']['error'];
		$tmpfile = $_FILES['gambar']['tmp_name'];
		
		$foto = verify_file($namafile, $sizefile, $errorfile, $tmpfile, $_POST['nik-toedit'], $koneksi);
		
		mysqli_query($koneksi, "update data_warga set 
		nik='".$_POST['nik']."', 
		nama='".$_POST['nama']."', 
		alamat='".$_POST['alamat']."',
		pekerjaan='".$_POST['pekerjaan']."',
		ttl='".$_POST['ttl']."/".$_POST['ttl2']."',
		agama='".$_POST['agama']."',
		telepon='".$_POST['telepon']."',
		email='".$_POST['email']."'".$foto." where nik='".$_POST['nik-toedit']."'");
		if(mysqli_affected_rows($koneksi) > 0){
			$_SESSION['konfirm'] = true;
		}
		else{
			$_SESSION['konfirm'] = false;
			if(!isset($_SESSION['warning'])) $_SESSION['warning'] = "Make sure you edit the data!!";
		}
	}
	
	if($_POST['nik'] == $_POST['nik-toedit']){
		edit($koneksi);
	}
	else{
		$check = mysqli_query($koneksi, "select nik from data_warga where nik = '".$_POST['nik']."'");
		if(mysqli_num_rows($check) > 0){
			$_SESSION['konfirm'] = false;
			$_SESSION['warning'] = "The \"Nik\" data don't be same with the other \"Nik\" data!!";
		}
		else{
			edit($koneksi);
		}
	}
	$_SESSION['message'] = "Edited!!";
	header("location:daftar_warga.php");
}

//Delete

if(isset($_GET['hapus'])){
	delFile($_GET['nik']);
	mysqli_query($koneksi, "delete from data_warga where nik='".$_GET['nik']."'");
	if(mysqli_affected_rows($koneksi) > 0){
			$_SESSION['konfirm'] = true;
		}
		else{
			$_SESSION['konfirm'] = false;
		}
	$_SESSION['message'] = "dihapus!!";
	header("location:daftar_warga.php");
}

//Foto

if(isset($_POST['login'])){
	$sql = mysqli_query($koneksi, "select * from login where username='".$_POST['username']."' and password='".md5($_POST['password'])."'");
	$data = mysqli_fetch_array($sql);
	if(mysqli_num_rows($sql) > 0){
		$_SESSION['username'] = $data['username'];
		header("location:index.php");
	}
	else{
		header("location:login.php?salah=true");
	}
}

function verify_file($namafile, $sizefile, $errorfile, $tmpfile, $nik = "xalahCuy", $koneksi){
	if(strlen($namafile) == 0){
		$querr = mysqli_query($koneksi, "select gambar from data_warga where nik='{$nik}'");
		if(mysqli_num_rows($querr) > 0){
			$data = mysqli_fetch_array($querr);
			$data = ",gambar='".$data[0]."'";
		}
		else{
			$data = "";
		}
		return $data;
		die;
	}
	if($errorfile === 4){
		header("location:daftar_warga.php");
		$_SESSION['message'] = "Upload file error!!";
		$_SESSION['konfirm'] = false;
		die;
	}
	
	$validex = ['jpg', 'jpeg', 'png', 'heic', 'gif', 'webp'];
	$filex = explode('.', $namafile);
	$filex = strtolower(end($filex));
	if(!in_array($filex, $validex)){
		header("location:daftar_warga.php");
		$_SESSION['message'] = "File is not image!!";
		$_SESSION['konfirm'] = false;
		die;
	}
	
	if($sizefile > 2000000){
		header("location:daftar_warga.php");
		$_SESSION['message'] = "Image size is too large!!";
		$_SESSION['konfirm'] = false;
		die;
	}
	delFile($nik);
	$newnamafile = uniqid().".".$filex;
	move_uploaded_file($tmpfile,'../XI_PPLG-1/Daftar_warga/img/'.$newnamafile);
	return ",gambar='img/".$newnamafile."'";
}

//hapus foto

function delFile($nike){
	include "koneksi_db.php";
	$data = mysqli_query($koneksi, "select gambar from data_warga where nik='".$nike."'");
	$data = mysqli_fetch_array($data);
	$_SESSION['img'] = $data['gambar'];
	$_SESSION['delete'] = true;
}

if(isset($_POST['getubah'])){
	$sqli = mysqli_query($koneksi, "select * from data_warga where nik='".$_POST['nik']."'");
	echo json_encode(mysqli_fetch_array($sqli));
}


if(isset($_GET['logout'])){
	unset($_SESSION['username']);
	header("location:index.php");
}