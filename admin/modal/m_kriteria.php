<?php
	include '../../config/koneksi.php';
	if(isset($_POST['btnSimpan'])){
		$btn = $_POST['btnSimpan'];
		
		$id_kompetensi = isset($_POST['id_kompetensi'])?mysql_real_escape_string(htmlspecialchars($_POST['id_kompetensi'])):"";
		$nama_kompetensi = isset($_POST['nama_kompetensi'])?mysql_real_escape_string(htmlspecialchars($_POST['nama_kompetensi'])):"";
		$bobot_kompetensi = isset($_POST['bobot_kompetensi'])?mysql_real_escape_string(htmlspecialchars($_POST['bobot_kompetensi'])):"";
		
		if($btn=="Tambah"){
			$sql = "INSERT INTO jenis_kompetensi ( nama_kompetensi, bobot_kompetensi) VALUES( '$nama_kompetensi', '$bobot_kompetensi') ";
		}else{
			$sql = "UPDATE jenis_kompetensi SET nama_kompetensi = '$nama_kompetensi', bobot_kompetensi = '$bobot_kompetensi' WHERE id_kompetensi = '$id_kompetensi'";
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
		header("location:../index.php?p=kriteria");
	}

	if(isset($_POST['btnDelete'])){
		$id_kompetensi = isset($_POST['id_delete'])?mysql_real_escape_string(htmlspecialchars($_POST['id_delete'])):"";
		$sql = "DELETE  FROM jenis_kompetensi WHERE id_kompetensi = $id_kompetensi";
		$query = mysql_query($sql);
		if($query){
			$_SESSION["flash"]["type"] = "success";
			$_SESSION["flash"]["head"] = "Sukses,";
			$_SESSION["flash"]["msg"] = "data berhasil dihapus!";
		}else{
			$_SESSION["flash"]["type"] = "danger";
			$_SESSION["flash"]["head"] = "Gagal,";
			$_SESSION["flash"]["msg"] = "data gagal dihapus! ".mysql_error();
		}
		header("location:../index.php?p=kriteria");
	}


	if(isset($_GET['sum'])){
		$sql = "SELECT SUM(bobot_kompetensi) as bobot FROM jenis_kompetensi";
		$q = mysql_query($sql);
		$row = mysql_fetch_assoc($q);
		echo $row['bobot']; 
		//print_r($data);
	}
?>