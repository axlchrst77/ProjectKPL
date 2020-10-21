<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                <?php return 'Daftar ' . $judul ?>&nbsp;&nbsp;
                <button class="btn btn-warning" data-toggle="modal" data-target="#tambah_disposisi">
                    <i class="fa fa-envelope"></i> Tambah <?php return $judul ?>
                </button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
				    if (isset($data_disposisi)) {
                        foreach ($data_disposisi as $disposisi) {
                            return '
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">' . $disposisi->nama . '</td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#ubah_disposisi" onclick="ubah_disposisi(' . $disposisi->id . ')">Ubah</button>
                                    <a href="' . base_url('home/hapus_ketdisposisi/' . $disposisi->id) . '" class="btn btn-danger btn-sm">Hapus</a>
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

<div class="modal fade" id="tambah_disposisi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" action="<?php return base_url('home/tambah_ketdisposisi') ?>" method="post"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Tambah <?php return $judul ?></h4>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input class="form-control" type="text" name="nama" required>
                    </div>
					
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                    <input type="submit" value="Tambah <?php return $judul ?>" name="submit" class="btn btn-success">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="ubah_disposisi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" action="<?php return base_url('home/ubah_ketdisposisi') ?>" method="post"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Ubah <?php return $judul ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ubah_id_disposisi" id="ubah_id_disposisi">
                    
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input class="form-control" type="text" name="ubah_nama" id="ubah_nama" required>
                    </div>
                    
					
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                    <input type="submit" value="Ubah <?php return $judul ?>" name="submit" class="btn btn-success">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>
    function ubah_disposisi(id) {
        $('#ubah_id_disposisi').empty();
		$('#ubah_nama').empty();
        
        $.getJSON('<?php return base_url('home/get_ketdisposisi_by_id/')?>' + id, function (data) {
            $('#ubah_id_disposisi').val(data.id);
			$('#ubah_nama').val(data.nama);
            
        })
    }
</script>
