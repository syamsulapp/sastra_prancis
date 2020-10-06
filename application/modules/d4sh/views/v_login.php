<div class="login_page_wrapper">
    <div class="md-card" id="login_card">
        <div class="md-card-content large-padding" id="login_form">
            <div class="login_heading">
                <div class="user_avatar1">
                    <?php if ($this->config->config['blogimgheader2'] != '') { ?><img src="<?php echo $this->config->config['blogimgheader2'] ?>"><?php } ?>
                </div>
            </div>
            <form name="form_login" id="form-login" action="<?php echo site_url('d4sh/validate_credentials'); ?>" method="post">
                <div class="uk-form-row">
                    <label for="login_username">Nama Pengguna</label>
                    <input class="md-input" type="text" id="login_username" title="Nama Pengguna" name="username" />
                </div>
                <div class="uk-form-row">
                    <label for="login_password">Kata Kunci</label>
                    <input class="md-input" type="password" id="login_password" title="Kata Kunci" name="password" />
                </div>
                <div class="uk-margin-medium-top">
                    <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Masuk</button>
                </div>
            </form>
        </div>
        <div class="md-card-content large-padding" id="register_form" style="display: none">
            <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
            <div class="login_heading">
                <div class="user_avatar1">
                    <img src="<?php echo $this->config->config['blogimgheader2'] ?>">
                </div>
            </div>
            <form name="form_lupapass" id="form-lupapass" action="<?php echo site_url('d4sh/checkemail'); ?>" method="post">
                <div class="uk-form-row">
                    <label for="register_username">Email Pengguna</label>
                    <input class="md-input" type="email" id="register_username" title="Email Pengguna" name="email" />
                </div>
                <div class="uk-margin-medium-top">
                    <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Ubah</a>
                </div>
            </form>
        </div>
    </div>
    <div class="uk-margin-top uk-text-center">
        <a href="<?php echo site_url(); ?>">Beranda<a> |
                <a href="#" id="signup_form_show">Lupa Kata Sandi</a>
                <a href="#" class="back_to_login">Kembali</a>
    </div>
</div>