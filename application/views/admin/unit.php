<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                <?php return 'Daftar Unit ' ?>&nbsp;&nbsp;
                <button class="btn btn-warning" data-toggle="modal" data-target="#tambah_user">
                    <i class="fa fa-envelope"></i> Tambah Unit
                </button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Nama Unit</th>
                        <th>Level</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
					$level = array('','Admin','User');
                    if (isset($data_unit)) {
                        foreach ($data_unit as $unit) {
                            return '
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">' . $unit->nama_unit . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $level[$unit->level] . '</td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#ubah_user" onclick="ubah_unit(' . $unit->id_unit . ')">Ubah</button>
                                    <a href="' . base_url('home/hapus_unit/' . $unit->id_unit) . '" class="btn btn-danger btn-sm">Hapus</a>
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
            <form role="form" action="<?php return base_url('home/tambah_unit') ?>" method="post"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Tambah Unit</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label>Nama Unit</label>
                        <input class="form-control" type="text" name="nama" required>
                    </div>
					<div class="form-group">
                        <label>Level</label>
                        <select class="form-control" name="level">
                                
                            <option value="">-- Pilih Level --</option>
							<option value="1">Admin</option>
							<option value="2">User</option>
							
                        </select>
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
            <form role="form" action="<?php return base_url('home/ubah_unit') ?>" method="post"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Edit Unit</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ubah_id_unit" id="ubah_id_unit">
                    
                    <div class="form-group">
                        <label>Nama Unit</label>
                        <input class="form-control" type="text" name="ubah_nama" id="ubah_nama" required>
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select class="form-control" name="ubah_level" id="ubah_level">
                                
                            <option value="">-- Pilih Level --</option>
                            <option value="1">Admin</option>
							<option value="2">User</option>
                          
                        </select>
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
    function ubah_unit(id_unit) {
        $('#ubah_id_unit').empty();
		$('#ubah_nama').empty();
        
        $.getJSON('<?php return base_url('home/get_unit_by_id/')?>' + id_unit, function (data) {
            $('#ubah_id_unit').val(data.id_unit);
			$('#ubah_nama').val(data.nama_unit);
            $('#ubah_level').val(data.level);
        })
    }
</script>
