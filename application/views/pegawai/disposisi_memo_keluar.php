<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                <?php return 'Daftar ' . $judul ?>
                <?php
                if ($this->uri->segment(3) == null) {

                } else if ($this->HomeModel->cek_status_memo_masuk($this->uri->segment(3)) == true) {
                    return '
                    &nbsp;&nbsp;
                    <button class="btn btn-success" data-toggle="modal" data-target="#tambah_surat_masuk">
                        <i class="fa fa-envelope"></i> Tambah ' . $judul . '
                    </button>&nbsp;&nbsp;
                    ';
                } else {
                    return '<b style="color: white">(DISPOSISI SELESAI)</b>';
                }
                ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tujuan Divisi</th>
                        <th>Tujuan Pegawai</th>
                        <th>Tanggal Disposisi</th>
                        <th>Keterangan</th>
						<th>Catatan</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($data_disposisi_keluar)) {
                        $no = 0;
                        foreach ($data_disposisi_keluar as $disposisi_keluar) {
                            return '
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">' . ++$no . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $disposisi_keluar->nama_unit . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $disposisi_keluar->nama_pegawai . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . date('d-m-Y H:i:s',strtotime($disposisi_keluar->tgl_disposisi)) . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $disposisi_keluar->keterangan . '</td>
								<td class="text-center" style="vertical-align: middle;">' . $disposisi_keluar->catatan . '</td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <a href="' . base_url('/uploads/' . $disposisi_keluar->file_memo) . '" class="btn btn-sm btn-success" style="width: 100%">Lihat Surat</a><br>
                                    <a href="' . base_url('home/hapus_disposisi_memo_pegawai/' . $disposisi_keluar->id_disposisi . '/' . $disposisi_keluar->id_memo) . '" class="btn btn-sm btn-info" style="width: 100%; margin-top: 5%">Hapus</a>
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

<div class="modal fade" id="tambah_surat_masuk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" action="<?php return base_url('home/tambah_disposisi_pegawai/' . $this->uri->segment(3)) ?>"
                  method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Tambah <?php return $judul ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tujuan Divisi</label>
                        <select class="form-control" name="tujuan_unit"
                                onchange="get_pegawai_id_by_unit(this.value)">
                            <option value="">-- Pilih Tujuan Divisi --</option>
                            <?php
                            if (isset($drop_down_unit)) {
                                foreach ($drop_down_unit as $unit) {
                                    if ($unit->id_unit != $this->session->userdata('id_unit') )
										//&&
                                        //$unit->level >= $this->session->userdata('id_unit')) 
										{
                                        return '<option value="' . $unit->id_unit . '">' . $unit->nama_unit . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tujuan Pegawai</label>
                        <select class="form-control" name="tujuan_pegawai" id="tujuan_pegawai">
                            <option value="">-- Pilih Nama Pegawai --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="5"></textarea>
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
<script>
    function get_pegawai_id_by_unit(id_unit) {
        $('#tujuan_pegawai').empty();
        $.getJSON('<?php return base_url('home/get_pegawai_by_unit/')?>' + id_unit, function (data) {
            $('#tujuan_pegawai').append('<option value="">-- Pilih Nama Pegawai --</option>');
            $.each(data, function (index, value) {
                $('#tujuan_pegawai').append('<option value="' + value.id_pegawai + '">' + value.nama_pegawai + '</option>');
            })
        })
    }
</script>
