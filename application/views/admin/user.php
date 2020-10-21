<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                <?php return 'Daftar User'  ?>&nbsp;&nbsp;
                <button class="btn btn-warning" data-toggle="modal" data-target="#tambah_user">
                    <i class="fa fa-envelope"></i> Tambah User
                </button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>User Name</th>
						<th>NIP</th>
                        <th>Nama Pegawai</th>
                        <th>Unit</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($data_user)) {
                        foreach ($data_user as $user) {
                            return '
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">' . $user->username . '</td>
								 <td class="text-center" style="vertical-align: middle;">' . $user->nip . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $user->nama_pegawai . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $user->nama_unit . '</td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#ubah_user" onclick="ubah_user(' . $user->id_pegawai . ')">Ubah</button>
                                    <a href="' . base_url('home/hapus_user/' . $user->id_pegawai) . '" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                            ';
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="modal fade" id="tambah_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" action="<?php return base_url('home/tambah_user') ?>" method="post"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Tambah User</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>User Name</label>
                        <input class="form-control" type="text" name="nik" required>
                    </div>
					  <div class="form-group">
                        <label>NIP</label>
                        <input class="form-control" type="text" name="nip" required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input class="form-control" type="text" name="nama" required>
                    </div>
					<div class="form-group">
                        <label>Unit</label>
                        <select class="form-control" name="unit"
                                onchange="get_pegawai_id_by_unit(this.value)">
                            <option value="">-- Pilih Unit --</option>
                            <?php
                            if (isset($drop_down_unit)) {
                                foreach ($drop_down_unit as $unit) {
                                    //if ($unit->id_unit != $this->session->userdata('id_unit')) {
                                        return '<option value="' . $unit->id_unit . '">' . $unit->nama_unit . '</option>';
                                    //}
                                }
                            }
                            ?>
                        </select>
                    </div>
					
					
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password" >
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                    <input type="submit" value="Tambahkan" name="submit" class="btn btn-success">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="ubah_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" action="<?php return base_url('home/ubah_user') ?>" method="post"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel"> Edit User</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ubah_id_user" id="ubah_id_user">
                    <div class="form-group">
                        <label>User Name</label>
                        <input class="form-control" type="text" name="ubah_nik" id="ubah_nik" required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input class="form-control" type="text" name="ubah_nama" id="ubah_nama" required readonly>
                    </div>
					  <div class="form-group">
                        <label>NIP</label>
                        <input class="form-control" type="text" name="ubah_nip" id="ubah_nip" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Unit</label>
                        <select class="form-control" name="ubah_unit" id="ubah_unit">
                                
                            <option value="">-- Pilih Unit --</option>
                            <?php
                            if (isset($drop_down_unit)) {
                                foreach ($drop_down_unit as $unit) {
                                    //if ($unit->id_unit != $this->session->userdata('id_unit')) {
                                        return '<option value="' . $unit->id_unit . '">' . $unit->nama_unit . '</option>';
                                    //}
                                }
                            }
                            ?>
                        </select>
                    </div>
					
					
					<div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="ubah_password" id="ubah_password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                    <input type="submit" value="Simpan" name="submit" class="btn btn-success">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>
    function ubah_user(id_user) {
        $('#ubah_id_user').empty();
		$('#ubah_nik').empty();
		$('#ubah_nip').empty();
        $('#ubah_nama').empty();
        //$('#ubah_unit').empty();
        $('#ubah_password').empty();
        
        $.getJSON('<?php return base_url('home/get_user_by_id/')?>' + id_user, function (data) {
            $('#ubah_id_user').val(data.id_pegawai);
			$('#ubah_nik').val(data.username);
			$('#ubah_nip').val(data.nip);
			$('#ubah_nama').val(data.nama_pegawai);
            $('#ubah_unit').val(data.id_unit);
        })
    }
</script>
