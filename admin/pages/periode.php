<?php
	if(isset($_GET['setaktif'])){
		$id_periode = isset($_GET['id_periode'])?mysql_real_escape_string(htmlspecialchars($_GET['id_periode'])):"";
		$sql = "UPDATE periode SET status_periode = 0";
		$up = mysql_query($sql);
		if($up){
			if(mysql_query("UPDATE periode SET status_periode = 1 WHERE id_periode = $id_periode")){
				$_SESSION["flash"]["type"] = "success";
				$_SESSION["flash"]["head"] = "Sukses,";
				$_SESSION["flash"]["msg"] = "data berhasil disimpan!";
				echo "<script>document.location='index.php?p=periode';</script>";
			}
		}
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Gagal,";
		$_SESSION["flash"]["msg"] = "data gagal disimpan! ".mysql_error();
		echo "<script>document.location='index.php?p=periode';</script>";

	}
?>


<?php 
	$btn = "Tambah"; 
	$icn = "plus";
	if(isset($_GET['ubah'])){
		$id_periode = isset($_GET['id_periode'])?mysql_real_escape_string(htmlspecialchars($_GET['id_periode'])):"";
		$sql = "SELECT * FROM periode WHERE id_periode = $id_periode";
		$q = mysql_query($sql);
		$data = [];
		while ($row = mysql_fetch_assoc($q)) {
			$id_periode = $row['id_periode']; 
			$tahun_penilaian = $row['tahun_penilaian']; 
			$semester = $row['semester']; 
			$btn = "Ubah"; 
			$icn = "edit";
			if($row['setting']!=''){
				$set = explode(';', $row['setting']);
				$atasan = $set[0];
				$rekan = $set[1];
				$diri = $set[2];
			}
		}

?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#exampleModal').modal('show');
		
		$('#exampleModal').on('hidden.bs.modal', function(e){
			document.location = 'index.php?p=periode';
		});
	});
</script>
<?php
	}
?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-calendar-alt"></i> Data Periode</h1>

    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah Data</button>
</div>

<?php if(isset($_SESSION["flash"])){ ?>
    <div class="alert alert-<?= $_SESSION["flash"]["type"]; ?> alert-dismissible alert_model" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <?= $_SESSION["flash"]["head"]; ?> <?= $_SESSION["flash"]["msg"]; ?>
    </div>
<?php unset($_SESSION['flash']); } ?>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-table"></i> Daftar Data Periode</h6>
    </div>

    <div class="card-body">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead class="bg-danger text-white">
                <tr align="center">
					<th width="5%">No</th>
					<th>Tahun Penilaian</th>
					<th>Semester</th>
					<th>Penilaian</th>
					<th>Status</th>
					<th width="15%">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$sql = "SELECT * FROM periode";
					$q = mysql_query($sql);
					$i=0;
					while($row = mysql_fetch_array($q)){
						$setting = '';
						if($row['setting']!=''){
							$set = explode(';', $row['setting']);
							$setting = "Atasan = $set[0]% <br>Rekan Kerja = $set[1]% <br>Diri Sendiri = $set[2]%";
						}

				?>
				<tr align="center">
					<td><?= ++$i; ?></td>
					<td><?= $row['tahun_penilaian']; ?></td>
					<td><?= $row['semester']; ?></td>
					<td><?= $setting; ?></td>
					<td>
						<?php if($row['status_periode']==0){ ?>
							<span class="badge badge-danger">Tidak Aktif</span>
						<?php }else{ ?>
							<span class="badge badge-success">Aktif</span>
						<?php } ?>
					</td>
					<td>
						<div class="btn-group" role="group">
							<?php if($row['status_periode']==0): ?>
							<a data-toggle="tooltip" data-placement="bottom" title="Aktifkan Data" href="index.php?p=periode&setaktif=true&id_periode=<?= $row['id_periode'];?>" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
							<?php endif; ?>
							<a data-toggle="tooltip" data-placement="bottom" title="Edit Data" href="index.php?p=periode&ubah=true&id_periode=<?= $row['id_periode'];?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-<?= $icn; ?>"></i> <?= $btn; ?> Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" method="post" action="modal/m_periode.php">
				<div class="modal-body">
					<input type="hidden" name="id_periode" <?= isset($id_periode)?'value="'.$id_periode.'"':""; ?>  >
					<input type="hidden" name="btnSimpan" value="<?= $btn; ?>" >
					
					<div class="form-group">
                        <label class="font-weight-bold">Tahun Penilaian</label>
                        <input autocomplete="off" type="text" name="tahun_penilaian" id="tahun_penilaian" value="<?= isset($tahun_penilaian)?$tahun_penilaian:""; ?>" required class="form-control" />
                    </div>
					
					<div class="form-group">
                        <label class="font-weight-bold">Semester</label>
                        <input autocomplete="off" type="text" name="semester" id="semester" value="<?= isset($semester)?$semester:""; ?>" required class="form-control" />
                    </div>
					
					<div class="form-group">
                        <label class="font-weight-bold">Presentase Atasan</label>
                        <input autocomplete="off" type="number" min="0" max="100" name="atasan" id="atasan" value="<?= isset($atasan)?$atasan:""; ?>" required class="form-control" />
                    </div>
					
					<div class="form-group">
                        <label class="font-weight-bold">Presentase Rekan Kerja</label>
                        <input autocomplete="off" type="number" min="0" max="100" name="rekan" id="rekan" value="<?= isset($rekan)?$rekan:""; ?>" required class="form-control" />
                    </div>
					
					<div class="form-group">
                        <label class="font-weight-bold">Presentase Diri Sendiri</label>
                        <input autocomplete="off" type="number" min="0" max="100" name="diri" id="diri" value="<?= isset($diri)?$diri:""; ?>" required class="form-control" />
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> <?= $btn; ?></button>
				</div>
			</form>
		</div>
	</div>
</div>