<?php
	include '../../config/koneksi.php';
	if(isset($_POST['btnSimpan'])){
		$btn = $_POST['btnSimpan'];
		
		$id_isi = isset($_POST['id_isi'])?mysql_real_escape_string(htmlspecialchars($_POST['id_isi'])):"";
		$id_kompetensi = isset($_POST['id_kompetensi'])?mysql_real_escape_string(htmlspecialchars($_POST['id_kompetensi'])):"";
		$isi_kompetensi = isset($_POST['isi_kompetensi'])?mysql_real_escape_string(htmlspecialchars($_POST['isi_kompetensi'])):"";
		$ket = isset($_POST['ket'])?mysql_real_escape_string(htmlspecialchars($_POST['ket'])):"";
		$penilai = isset($_POST['penilai'])?mysql_real_escape_string(htmlspecialchars($_POST['penilai'])):"";


		if($btn=="Tambah"){
			$sql = "INSERT INTO isi_kompetensi ( id_kompetensi, isi_kompetensi, ket) VALUES('$id_kompetensi', '$isi_kompetensi', '$penilai') ";
		}else{
			$sql = "UPDATE isi_kompetensi SET id_kompetensi = '$id_kompetensi', isi_kompetensi = '$isi_kompetensi', ket = '$penilai' WHERE id_isi = '$id_isi'";
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
		header("location:../index.php?p=subkriteria");
	}

	if(isset($_POST['btnDelete'])){
		$id_isi = isset($_POST['id_delete'])?mysql_real_escape_string(htmlspecialchars($_POST['id_delete'])):"";
		$sql = "DELETE  FROM isi_kompetensi WHERE id_isi = $id_isi";
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
		header("location:../index.php?p=subkriteria");
	}

?>