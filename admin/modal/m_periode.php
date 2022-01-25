<?php
	include '../../config/koneksi.php';
	if(isset($_POST['btnSimpan'])){
		$btn = $_POST['btnSimpan'];
		
		$id_periode = isset($_POST['id_periode'])?mysql_real_escape_string(htmlspecialchars($_POST['id_periode'])):"";
		$tahun_penilaian = isset($_POST['tahun_penilaian'])?mysql_real_escape_string(htmlspecialchars($_POST['tahun_penilaian'])):"";
		$semester = isset($_POST['semester'])?mysql_real_escape_string(htmlspecialchars($_POST['semester'])):"";
		$status_periode = 1;

		$atasan = isset($_POST['atasan'])?mysql_real_escape_string(htmlspecialchars($_POST['atasan'])):"";
		$rekan = isset($_POST['rekan'])?mysql_real_escape_string(htmlspecialchars($_POST['rekan'])):"";
		$diri = isset($_POST['diri'])?mysql_real_escape_string(htmlspecialchars($_POST['diri'])):"";

		$tot = $atasan+$rekan+$diri;
		echo "$tot = $atasan+$rekan+$diri";

		if($tot==100){
			
			$setting = "$atasan;$rekan;$diri";

			if($btn=="Tambah"){
				

				$ssq = "SELECT * FROM periode WHERE tahun_penilaian = $tahun_penilaian AND LOWER(semester) = LOWER('$semester')";
				$q = mysql_query($ssq);
				if(mysql_num_rows($q)>0){
					$sql = "";
				}else{
					$ssq = "UPDATE periode SET status_periode = 0";
					mysql_query($ssq);
					$sql = "INSERT INTO periode (tahun_penilaian, semester, status_periode, setting) VALUES( '$tahun_penilaian', '$semester', '$status_periode', '$setting') ";
					
				}
			}else{
				$sql = "UPDATE periode SET tahun_penilaian = '$tahun_penilaian', semester = '$semester', setting='$setting' WHERE id_periode = '$id_periode'";
			}

			$query = mysql_query($sql);
			if($query){
				$_SESSION["flash"]["type"] = "success";
				$_SESSION["flash"]["head"] = "Sukses,";
				$_SESSION["flash"]["msg"] = "data berhasil disimpan!";
			}else{
				$_SESSION["flash"]["type"] = "danger";
				$_SESSION["flash"]["head"] = "Gagal,";
				$_SESSION["flash"]["msg"] = "data gagal disimpan! ";//.mysql_error();
			}
			header("location:../index.php?p=periode");
		}else{
			
			$_SESSION["flash"]["type"] = "danger";
			$_SESSION["flash"]["head"] = "Gagal,";
			$_SESSION["flash"]["msg"] = "data gagal disimpan! ";//.mysql_error();
			header("location:../index.php?p=periode");
		}
	}

	if(isset($_POST['btnDelete'])){
		$id_periode = isset($_POST['id_delete'])?mysql_real_escape_string(htmlspecialchars($_POST['id_delete'])):"";
		$sql = "DELETE  FROM periode WHERE id_periode = $id_periode";
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
		header("location:../index.php?p=periode");
	}

?>