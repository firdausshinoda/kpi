<html>
<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-brown">
                <div class='box-header with-border'>
                    <div class='user-block'>
                        <span class='username'>Buat ID Kerja Praktik</span>
                    </div>
                </div>
                <div class="box-body box-profile">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <h3 id="idkpgenerate" class="form-control"></h3>
                        </li>
                        <li class="list-group-item">
                            <button type="submit" onclick="generate()"; class="btn btn-default btn-block"> Generate ID <i class="fa fa-save"></i></button>
                            <br><div class="user-block">
                                <span class="description">Silahkan klik tombol Generate ID untuk mendapatkan ID KP invdividu maupun kelompok.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li id="agenda_form"><a onclick="tab('agenda_form')" href="javascript:void(0);" data-toggle="tab">Form KP</a></li>
                    <li id="agenda_data_perusahaan"><a onclick="tab('agenda_data_perusahaan')" href="javascript:void(0);" data-toggle="tab">Data Perusahaan</a></li>
                    <li id="agenda_pembimbing"><a onclick="tab('agenda_pembimbing')" href="javascript:void(0);" data-toggle="tab">Pembimbing</a></li>
                    <li id="agenda_data_kp"><a onclick="tab('agenda_data_kp')" href="javascript:void(0);" data-toggle="tab">Data KP</a></li>
                    <li id="agenda_kp_harian"><a onclick="tab('agenda_kp_harian')" href="javascript:void(0);" data-toggle="tab">Tugas KP Harian</a></li>
                    <li id="agenda_kp_bimbingan"><a onclick="tab('agenda_kp_bimbingan')" href="javascript:void(0);" data-toggle="tab">Bimbingan KP</a></li>
                </ul>
                <div class="active tab-pane">
                    <div id="formkp"></div>
                </div>
            </div>
        </div>
    </div>
</section>
</html>
