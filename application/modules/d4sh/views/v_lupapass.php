<div class="wrap">
    <div class="row">
        <div class="col-lg-12 text-center" style="margin-top:-58px">
            <div class="form-box text-center listing berita-auto listing-blue shadow" id="lupapass-box" style="display:none">
                <div class="header bg-grey">
                    <i class="glyphicon glyphicon-warning-sign"></i> Lupa Kata Kunci
                </div>
                <form name="form_lupapass" id="form-lupapass" action="<?php echo site_url('login/checkemail'); ?>" method="post">
                    <div class="body bg-black">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input type="email" id="email" title="Email Pengguna" name="email" class="form-control square-btn-adjust required" placeholder="Email Pengguna"/>
                            </div>
                        </div>
                    </div>
                    <div class="footer bg-blue text-center">
                        <button title="Kembali ke Halaman Utama" type="reset" class="btn text-green square-btn-adjust" onclick="back_login();"><i class="glyphicon glyphicon-home"></i> Kembali</button>
                        <button title="Ubah Kata Kunci Baru" type="submit" class="btn text-blue square-btn-adjust" onclick="lupapass();">Ubah <i class="glyphicon glyphicon-log-in"></i></button>  
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>