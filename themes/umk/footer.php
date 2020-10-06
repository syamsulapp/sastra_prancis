<footer class="page_footer cs section_padding_top_100 section_padding_bottom_65 table_section">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-6 text-center text-sm-left">
				<div class="widget widget_text">
					<a href="./" class="logo vertical_logo">
						<img src="<?= base_url('themes/umk/assets/images/logo.jpeg') ?>" alt="" width="350" height="350">
					</a>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 text-center text-sm-left">
				<div class="widget widget_text">
					<h4 class="widget-title">Kontak</h4>
					<p>
						<i class="fa fa-globe fontsize_18 highlight2 rightpadding_10" aria-hidden="true"></i> <?php echo $this->config->config['blogname'] ?>
					</p>
					<p>
						<i class="fa fa-envelope fontsize_18 highlight2 rightpadding_10" aria-hidden="true"></i> fib@uho.ac.id
					</p>
					<p>
						<i class="fa fa-phone fontsize_18 highlight2 rightpadding_10" aria-hidden="true"></i> +62 (401) 3084783
					</p>
					<p class="greylinks">
						<i class="fa fa-internet-explorer fontsize_18 highlight2 rightpadding_10" aria-hidden="true"></i> <a href="#0">https://www.fib.uho.ac.id/</a>
					</p>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 text-center text-sm-left">
				<div class="widget widget_twitter">
					<h4 class="widget-title">Latest Tweets</h4>
					<div class="twitter"></div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 text-center text-sm-left">
				<div class="widget widget_mailchimp">

					<h4 class="widget-title">Subscribe Newsletter</h4>

					<form class="signup" action="./" method="get">
						<p class="fontsize_14">Enter Email here to be updated. We promise not to send you spam!</p>
						<div class="form-group">
							<label for="mailchimp" class="sr-only">Enter your email here</label>
							<i class="flaticon-envelope icon2-"></i>
							<input name="email" type="email" id="mailchimp" class="mailchimp_email form-control" placeholder="Emai Address">
							<button type="submit" class="theme_button color1">Subscribe</button>
						</div>

						<div class="response"></div>

					</form>

				</div>
			</div>
		</div>
	</div>
</footer>

<section class="cs page_copyright section_padding_15 with_top_border_container">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<p>&copy; Copyright <?= date('Y') ?>. Developed By Greentech Studio.</p>
			</div>
		</div>
	</div>
</section>


<!-- Bootstrap core JavaScript
		================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="<?= base_url('themes/umk/assets/js/compressed.js') ?>"></script>
<script src="<?= base_url('themes/umk/assets/js/main.js') ?>"></script>
<script src="<?= base_url('themes/umk/assets/js/vendor/modernizr-2.6.2.min.js') ?>"></script>