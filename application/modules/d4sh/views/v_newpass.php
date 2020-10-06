<div class="login_page_wrapper">
    <div class="md-card" id="login_card">
        <div class="md-card-content large-padding" id="login_form">
            <div class="login_heading">
                <div class="user_avatar1">
                    <img src="<?php echo $this->config->config['blogimgheader2'] ?>">
                </div>
            </div>
            <form name="form_newpass" id="form-newpass" action="<?php echo site_url('login/setpass'); ?>" method="post">
                <div class="uk-form-row">
                    <label for="login_username"><strong><?php echo $this->session->userdata('email');?></strong></label>
                    <input name="email2" type="hidden" value="<?php echo $this->session->userdata('email');?>">
                    <input name="uid" type="hidden" value="<?php echo $this->session->userdata('uid');?>">
                </div>
                <div class="uk-form-row">
                    <label for="login_username">Kata Kunci</label>
                    <input class="md-input" type="password" id="login_username" title="Kata Kunci Baru" name="password1" />
                </div>
                <div class="uk-form-row">
                    <label for="login_password">Konfirmasi Kata Kunci</label>
                    <input class="md-input" type="password" id="login_password" title="Ulangi Kata Kunci" name="password2" />
                </div>
                <div class="uk-margin-medium-top">
                    <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Ubah</button>
                </div>
            </form>
        </div>
    </div>
    <div class="uk-margin-top uk-text-center">
        <a href="<?php echo site_url();?>">Beranda<a> | 
        <a href="<?php echo site_url('login');?>">Kembali</a>
    </div>
</div>