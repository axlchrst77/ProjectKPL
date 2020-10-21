<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php return 'Daftar Memo Keluar'?> &nbsp;&nbsp;
                <button class="btn btn-info" data-toggle="modal" data-target="#tambah_memo_keluar">
                    <i class="fa fa-envelope"></i> Tambah Memo Keluar
                </button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Nomor Memo</th>
                        <th>Tanggal Kirim</th>
                        <th>Tujuan</th>
                        <th>Perihal</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($data_memo_keluar)) {
                        foreach ($data_memo_keluar as $memo_keluar) {
                            return '
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">' . $memo_keluar->nomor_memo . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . date('d-m-Y',strtotime($memo_keluar->tgl_kirim)) . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $memo_keluar->tujuan . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $memo_keluar->perihal . '</td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <a href="' . base_url('uploads/' . $memo_keluar->file_memo) . '" class="btn btn-info btn-sm">Lihat</a>
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#ubah_memo_keluar" onclick="ubah_memo(' . $memo_keluar->id_memo . ')">Ubah</button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah_file_memo_keluar" onclick="ubah_memo(' . $memo_keluar->id_memo . ')">Ubah memo</button>
                                    <a href="' . base_url('home/hapus_memo_keluar/' . $memo_keluar->id_memo) . '" class="btn btn-danger btn-sm">Hapus</a>
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

<div class="modal fade" id="tambah_memo_keluar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" action="<?php return base_url('home/tambah_memo_keluar') ?>" method="post"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Tambah <?php return $judul ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor memo</label>
                        <input class="form-control" type="text" name="nomor_memo" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Kirim</label>
                        <input class="form-control" type="date" name="tgl_kirim" required>
                    </div>
                    <div class="form-group">
                        <label>Tujuan</label>
                        <input class="form-control" type="text" name="tujuan" required>
                    </div>
                    <div class="form-group">
                        <label>Perihal</label>
                        <textarea class="form-control" rows="1" name="perihal" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>File memo</label>
                        <input class="form-control" type="file" accept="application/pdf" name="file_memo" required>
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

<div class="modal fade" id="ubah_memo_keluar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" action="<?php return base_url('home/ubah_memo_keluar') ?>" method="post"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Ubah <?php return $judul ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ubah_id_memo" id="ubah_id_memo">
                    <div class="form-group">
                        <label>Nomor memo</label>
                        <input class="form-control" type="text" name="ubah_nomor_memo" id="ubah_nomor_memo" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Kirim</label>
                        <input class="form-control" type="date" name="ubah_tgl_kirim" id="ubah_tgl_kirim" required>
                    </div>
                    <div class="form-group">
                        <label>Tujuan</label>
                        <input class="form-control" type="text" name="ubah_tujuan" id="ubah_tujuan" required>
                    </div>
                    <div class="form-group">
                        <label>Perihal</label>
                        <textarea class="form-control" rows="1" name="ubah_perihal" id="ubah_perihal"
                                  required></textarea>
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

<div class="modal fade" id="ubah_file_memo_keluar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" action="<?php return base_url('home/ubah_file_memo_keluar') ?>" method="post"
                  enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Ubah File <?php return $judul ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ubah_file_memo" id="ubah_file_memo">
                    <div class="form-group">
                        <label>File memo</label>
                        <input class="form-control" type="file" accept="application/pdf" name="ubah_file_memo"
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                    <input type="submit" value="Ubah File <?php return $judul ?>" name="submit" class="btn btn-success">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>    <!-- /.modal-dialog -->
</div>

<script>
    function ubah_memo(id_memo) {
        $('#ubah_id_memo').empty();
        $('#ubah_nomor_memo').empty();
        $('#ubah_tgl_kirim').empty();
        $('#ubah_tujuan').empty();
        $('#ubah_perihal').empty();
        $('#ubah_file_memo').empty();

        $.getJSON('<?php return base_url('home/get_memo_keluar_by_id/')?>' + id_memo, function (data) {
            $('#ubah_id_memo').val(data.id_memo);
            $('#ubah_nomor_memo').val(data.nomor_memo);
            $('#ubah_tgl_kirim').val(data.tgl_kirim);
            $('#ubah_tujuan').val(data.tujuan);
            $('#ubah_perihal').val(data.perihal);
            $('#ubah_file_memo').val(data.id_memo);
        })
    }
</script>
