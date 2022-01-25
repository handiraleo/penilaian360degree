<?php
	include '../../config/koneksi.php';
	if(isset($_POST['btnSimpan'])){
		$btn = $_POST['btnSimpan'];
		
		$id_jenis_user = isset($_POST['id_jenis_user'])?mysql_real_escape_string(htmlspecialchars($_POST['id_jenis_user'])):"";
		$jabatan = isset($_POST['jabatan'])?mysql_real_escape_string(htmlspecialchars($_POST['jabatan'])):"";
		$level = isset($_POST['level'])?mysql_real_escape_string(htmlspecialchars($_POST['level'])):"";

		if($btn=="Tambah"){
			$sql = "INSERT INTO jenis_user (jabatan, level) VALUES('$jabatan', '$level') ";
		}else{
			$sql = "UPDATE jenis_user SET jabatan = '$jabatan', level = '$level' WHERE id_jenis_user = '$id_jenis_user'";
		}

		$query = mysql_query($sql);
		if($query){
			$_SESSION["flash"]["type"] = "success";
			$_SESSION["flash"]["head"] = "Sukses,";
			$_SESSION["flash"]["msg"] = "data berhasil disimpan!";
		}else{
			$_SESSION["flash"]["type"] = "danger";
			$_SESSION["flash"]["head"] = "Gagal,";
			$_SESSION["flash"]["msg"] = "data gagal disimpan! ".mysql_error();
		}
		header("location:../index.php?p=jenisalternatif");
	}

	

?>