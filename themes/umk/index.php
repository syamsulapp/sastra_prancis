<!-- PART::section header -->
<?php get_header(); ?>

<?php if (isset($is_home)) { ?>

	<!-- Begin page content slider -->
	<section class="intro_section page_mainslider ds">
		<div class="flexslider vertical-nav" data-dots="true" data-nav="false">
			<ul class="slides">

				<li>
					<img src="<?= base_url('themes/umk/assets/images/slide01.jpg') ?>" alt="">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 text-left">
								<div class="slide_description_wrapper">
									<div class="slide_description">
										<div class="intro-layer" data-animation="fadeInUp">
											<h2>
												<span class="highlight2">Education</span> can be
												<br> started at
												<span class="highlight2">Any Age</span>!
											</h2>
										</div>
										<div class="intro-layer" data-animation="fadeInUp">
											<p>
												Make education your dream and it will help you to fulfill your dream.<br> Education takes us to the heights of success.
											</p>
										</div>
										<div class="intro-layer" data-animation="fadeInUp">
											<a href="courses.html" class="theme_button color2 two_lines_button">
												Choose starford<br> today
											</a>
										</div>
									</div>
									<!-- eof .slide_description -->
								</div>
								<!-- eof .slide_description_wrapper -->
							</div>
							<!-- eof .col-* -->
						</div>
						<!-- eof .row -->
					</div>
					<!-- eof .container -->
				</li>

				<li>
					<img src="<?= base_url('themes/umk/assets/images/slide02.jpg') ?>" alt="">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 text-center">
								<div class="slide_description_wrapper">
									<div class="slide_description">
										<div class="intro-layer" data-animation="fadeInUp">
											<h2>
												<span class="highlight2">Education</span> is a tool that
												<br> helps us get
												<span class="highlight2">Success</span>!
											</h2>
										</div>
										<div class="intro-layer" data-animation="fadeInUp">
											<p>
												Make education your dream and it will help you to fulfill your dream.<br> Education takes us to the heights of success.
											</p>
										</div>
										<div class="intro-layer" data-animation="fadeInUp">
											<a href="courses.html" class="theme_button color2 two_lines_button">
												Choose starford<br> today
											</a>
										</div>
									</div>
									<!-- eof .slide_description -->
								</div>
								<!-- eof .slide_description_wrapper -->
							</div>
							<!-- eof .col-* -->
						</div>
						<!-- eof .row -->
					</div>
					<!-- eof .container -->
				</li>

				<li>
					<img src="<?= base_url('themes/umk/assets/images/slide03.jpg') ?>" alt="">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 text-center">
								<div class="slide_description_wrapper">
									<div class="slide_description">
										<div class="intro-layer" data-animation="fadeInUp">
											<h2>
												<span class="highlight2">Education</span> is like passport to
												<br> the
												<span class="highlight2">Better Future</span>!
											</h2>
										</div>
										<div class="intro-layer" data-animation="fadeInUp">
											<p>
												Make education your dream and it will help you to fulfill your dream.<br> Education takes us to the heights of success.
											</p>
										</div>
										<div class="intro-layer" data-animation="fadeInUp">
											<a href="courses.html" class="theme_button color2 two_lines_button">
												Choose starford<br> today
											</a>
										</div>
									</div>
									<!-- eof .slide_description -->
								</div>
								<!-- eof .slide_description_wrapper -->
							</div>
							<!-- eof .col-* -->
						</div>
						<!-- eof .row -->
					</div>
					<!-- eof .container -->
				</li>

			</ul>
		</div>
	</section>

	<!-- find course -->
	<section class="ls section_padding_top_20 section_padding_bottom_10 top_offset_content">
		<div class="container">
			<div class="isotope_container isotope row masonry-layout columns_margin_bottom_20">
				<div class="isotope-item col-lg-4 col-md-6 col-sm-6 col-xs-12">
					<div class="with_padding gradient_bg_color cs">
						<h4 class="highlight2 bottommargin_30">
							Find Your Course
						</h4>
						<form action="./">
							<p>Fill out the form below to find the course for yourself:</p>
							<div class="content-justify bottommargin_30">
								<div class="checkbox margin_0">
									<input type="checkbox" id="course-filter-checkbox1" name="course-filter">
									<label for="course-filter-checkbox1">by ID</label>
								</div>
								<div class="checkbox margin_0">
									<input type="checkbox" id="course-filter-checkbox2" name="course-filter">
									<label for="course-filter-checkbox2">by name</label>
								</div>
								<div class="checkbox margin_0">
									<input type="checkbox" id="course-filter-checkbox3" name="course-filter">
									<label for="course-filter-checkbox3">by code</label>
								</div>
							</div>
							<div class="form-group">
								<label for="course-name" class="sr-only">Course Name
									<span class="required">*</span>
								</label>
								<input type="text" aria-required="true" size="30" value="" name="course-name" id="course-name" class="form-control" placeholder="Course Name">
							</div>
							<div class="form-group select-group">
								<label for="category" class="sr-only">Select Category</label>
								<select id="category" name="category" class="choice empty form-control">
									<option value="" disabled="" selected="" data-default="">Category</option>
									<option value="cat_1">Category 1</option>
									<option value="cat_2">Category 2</option>
									<option value="cat_3">Category 3</option>
								</select>
								<i class="fa fa-angle-down theme_button" aria-hidden="true"></i>
							</div>
							<div class="topmargin_30">
								<button type="submit" id="search_course_form_submit" name="search_course_submit" class="theme_button color2">Search course</button>
							</div>
						</form>
					</div>
				</div>
				<div class="isotope-item col-lg-4 col-md-6 col-sm-6 col-xs-12">
					<div class="teaser gradient_bg_color icon-background-teaser hoverable-banner before_cover text-center">
						<img src="images/teaser_icon01.png" alt="" class="icon-background">
						<h4 class="highlight2 topmargin_0">
							Science
						</h4>
						<p class="bottommargin_0">
							Leberkas hamburger cow ba<br> t-bone pork belly ribeye, por<br> chop swine andouille.
						</p>
						<div class="media-links">
							<a href="#" class="abs-link"></a>
						</div>
					</div>
				</div>
				<div class="isotope-item col-lg-4 col-md-6 col-sm-6 col-xs-12">
					<div class="teaser gradient_bg_color icon-background-teaser hoverable-banner before_cover text-center">
						<img src="images/teaser_icon02.png" alt="" class="icon-background">
						<h4 class="highlight2 topmargin_0">
							Genetics
						</h4>
						<p class="bottommargin_0">
							Tri-tip meatloaf short loin, turkey<br> corned beef flank burgdoggen<br> landjaeger t-bone shank.
						</p>
						<div class="media-links">
							<a href="#" class="abs-link"></a>
						</div>
					</div>
				</div>
				<div class="isotope-item col-lg-4 col-md-6 col-sm-6 col-xs-12">
					<div class="teaser gradient_bg_color icon-background-teaser hoverable-banner before_cover text-center">
						<img src="images/teaser_icon03.png" alt="" class="icon-background">
						<h4 class="highlight2 topmargin_0">
							Medicine
						</h4>
						<p class="bottommargin_0">
							Swine pork hamburger cupim<br> pork loin. Bresaola landjaeger tenderloin<br> meatball t-bone.
						</p>
						<div class="media-links">
							<a href="#" class="abs-link"></a>
						</div>
					</div>
				</div>
				<div class="isotope-item col-lg-4 col-md-6 col-sm-6 col-xs-12">
					<div class="teaser gradient_bg_color icon-background-teaser hoverable-banner before_cover text-center">
						<img src="images/teaser_icon04.png" alt="" class="icon-background">
						<h4 class="highlight2 topmargin_0">
							Astronomy
						</h4>
						<p class="bottommargin_0">
							Pork loin leberkas alcatra<br> hamburger fatback venison<br> beef ribs tri-tip landja.
						</p>
						<div class="media-links">
							<a href="#" class="abs-link"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- photos -->
	<section class="ls section_padding_top_100 section_padding_bottom_100 columns_margin_bottom_30 columns_padding_25 table_section table_section_md">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="with_pos_button left_button">
						<img src="images/about.jpg" alt="" />
						<a href="gallery-regular-3-cols.html" class="theme_button color2 two_lines_button">
							View more<br> photos
						</a>
					</div>
				</div>
				<div class="col-md-6">
					<h2 class="section_header highlight">
						The Story of StarFord
					</h2>
					<hr class="star_divider">
					<p class="fontsize_18">
						Phoenix was the world’s first modern industrial city. The history of the StarFord is entwined with the history of our city and region.
					</p>
					<p>
						StarFord, in its present form, was created in 2004 by the amalgamation of the Victoria University and the University of Institute of Science and Technology. After 100 hundred years of working closely together both institutions agreed
						to form a single university.
					</p>
					<p class="topmargin_30">
						<a href="#" class="read-more">read more</a>
					</p>
				</div>
			</div>
		</div>
	</section>
	<!-- testimoni  -->
	<section class="cs parallax page_testimonials section_padding_top_100">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<div class="owl-carousel testimonials_faces" data-nav="false" data-dots="false" data-margin="0" data-responsive-xs="3" data-resposive-sm="3" data-responsive-md="3" data-responsive-lg="3" data-mouse-drag="false" data-touch-drag="false" data-center="true">
						<div>
							<img src="images/faces/01.jpg" alt="">
						</div>
						<div>
							<img src="images/faces/02.jpg" alt="">
						</div>
						<div>
							<img src="images/faces/03.jpg" alt="">
						</div>
					</div>
					<div class="flexslider testimonials_flexslider" data-nav="true" data-dots="true" data-autoplay="false">
						<ul class="slides">
							<li>
								<blockquote class="with_quote topmargin_0">

									<div class="item-meta">
										<h5>
											<a href="#0">Iva Strickland</a>
										</h5>
										<span class="small-text highlight">student</span>
									</div>
									Sed condimentum vehicula porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pretium consectetur ultricies. Nulla tortor felis, tincidunt eget lectus vitae, vehicula pellentesque enim. Vestibulum vel massa non
									dui gravida malesuada.
									Pellentesque bibendum urna.
								</blockquote>
							</li>
							<li>
								<blockquote class="with_quote topmargin_0">

									<div class="item-meta">
										<h5>
											<a href="#0">Iva Strickland</a>
										</h5>
										<span class="small-text highlight">student</span>
									</div>
									Sed condimentum vehicula porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pretium consectetur ultricies. Nulla tortor felis, tincidunt eget lectus vitae, vehicula pellentesque enim. Vestibulum vel massa non
									dui gravida malesuada.
									Pellentesque bibendum urna.
								</blockquote>
							</li>
							<li>
								<blockquote class="with_quote topmargin_0">

									<div class="item-meta">
										<h5>
											<a href="#0">Iva Strickland</a>
										</h5>
										<span class="small-text highlight">student</span>
									</div>
									Sed condimentum vehicula porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pretium consectetur ultricies. Nulla tortor felis, tincidunt eget lectus vitae, vehicula pellentesque enim. Vestibulum vel massa non
									dui gravida malesuada.
									Pellentesque bibendum urna.
								</blockquote>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- list course dalam bentuk coursel -->
	<section class="ls section_padding_top_100 section_padding_bottom_100">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2 class="section_header highlight">
						Our Featured Courses
					</h2>
					<hr class="star_divider">
					<p class="fontsize_18">
						Bresaola brisket short loin sausage porchetta fatback ground round pastrami burgdoggen pork jowl jerky venison sirloin ribeye.
					</p>

					<div class="owl-carousel topmargin_60" data-responsive-lg="3" data-nav="true">
						<div class="vertical-item content-padding with_border">
							<div class="item-media">
								<img src="images/courses/07.jpg" alt="">
							</div>
							<header class="gradient_bg_color cs post-relater-person">
								<a href="team-single.html" class="avatar">
									<img src="images/team/01-small.jpg" alt="">
								</a>
								<span class="playfair fontsize_22">
									<a href="#0">Zachary Mendoza</a>
								</span>
							</header>
							<div class="item-content">
								<div class="catogories-links highlight2links small-text medium">
									<a href="courses.html">Medicine</a>
								</div>
								<h4 class="entry-title">
									<a href="course-sample.html">Treating Crohn S Disease With A Special Diet</a>
								</h4>
							</div>
							<footer class="item-meta bordered-meta greylinks">
								<div>
									<a href="#0">
										<i class="fa fa-users rightpadding_5" aria-hidden="true"></i>
										<span>3269</span>
									</a>
								</div>
								<div>
									<a href="#0">
										<i class="fa fa-comments rightpadding_5" aria-hidden="true"></i>
										<span>126</span>
									</a>
								</div>
								<div>
									<a href="#0">
										<i class="fa fa-money rightpadding_5" aria-hidden="true"></i>
										<span>550$</span>
									</a>
								</div>
							</footer>
						</div>

						<div class="vertical-item content-padding with_border">
							<div class="item-media">
								<img src="images/courses/04.jpg" alt="">
							</div>
							<header class="gradient_bg_color cs post-relater-person">
								<a href="team-single.html" class="avatar">
									<img src="images/team/02-small.jpg" alt="">
								</a>
								<span class="playfair fontsize_22">
									<a href="#0">Charlotte Hanson</a>
								</span>
							</header>
							<div class="item-content">
								<div class="catogories-links highlight2links small-text medium">
									<a href="courses.html">Painting</a>
								</div>
								<h4 class="entry-title">
									<a href="course-sample.html">How To Maintain Your Mental Health</a>
								</h4>
							</div>
							<footer class="item-meta bordered-meta greylinks">
								<div>
									<a href="#0">
										<i class="fa fa-users rightpadding_5" aria-hidden="true"></i>
										<span>3269</span>
									</a>
								</div>
								<div>
									<a href="#0">
										<i class="fa fa-comments rightpadding_5" aria-hidden="true"></i>
										<span>126</span>
									</a>
								</div>
								<div>
									<a href="#0">
										<i class="fa fa-money rightpadding_5" aria-hidden="true"></i>
										<span>550$</span>
									</a>
								</div>
							</footer>
						</div>

						<div class="vertical-item content-padding with_border">
							<div class="item-media">
								<img src="images/courses/06.jpg" alt="">
							</div>
							<header class="gradient_bg_color cs post-relater-person">
								<a href="team-single.html" class="avatar">
									<img src="images/team/03-small.jpg" alt="">
								</a>
								<span class="playfair fontsize_22">
									<a href="#0">George Daniel</a>
								</span>
							</header>
							<div class="item-content">
								<div class="catogories-links highlight2links small-text medium">
									<a href="courses.html">Sports</a>
								</div>
								<h4 class="entry-title">
									<a href="course-sample.html">The Key To Your Motivation And Success</a>
								</h4>
							</div>
							<footer class="item-meta bordered-meta greylinks">
								<div>
									<a href="#0">
										<i class="fa fa-users rightpadding_5" aria-hidden="true"></i>
										<span>3269</span>
									</a>
								</div>
								<div>
									<a href="#0">
										<i class="fa fa-comments rightpadding_5" aria-hidden="true"></i>
										<span>126</span>
									</a>
								</div>
								<div>
									<a href="#0">
										<i class="fa fa-money rightpadding_5" aria-hidden="true"></i>
										<span>550$</span>
									</a>
								</div>
							</footer>
						</div>

						<div class="vertical-item content-padding with_border">
							<div class="item-media">
								<img src="images/courses/04.jpg" alt="">
							</div>
							<header class="gradient_bg_color cs post-relater-person">
								<a href="team-single.html" class="avatar">
									<img src="images/team/04-small.jpg" alt="">
								</a>
								<span class="playfair fontsize_22">
									<a href="#0">Esther Craig</a>
								</span>
							</header>
							<div class="item-content">
								<div class="catogories-links highlight2links small-text medium">
									<a href="courses.html">Medicine</a>
								</div>
								<h4 class="entry-title">
									<a href="course-sample.html">Law Of Life</a>
								</h4>
							</div>
							<footer class="item-meta bordered-meta greylinks">
								<div>
									<a href="#0">
										<i class="fa fa-users rightpadding_5" aria-hidden="true"></i>
										<span>3269</span>
									</a>
								</div>
								<div>
									<a href="#0">
										<i class="fa fa-comments rightpadding_5" aria-hidden="true"></i>
										<span>126</span>
									</a>
								</div>
								<div>
									<a href="#0">
										<i class="fa fa-money rightpadding_5" aria-hidden="true"></i>
										<span>550$</span>
									</a>
								</div>
							</footer>
						</div>

						<div class="vertical-item content-padding with_border">
							<div class="item-media">
								<img src="images/courses/05.jpg" alt="">
							</div>
							<header class="gradient_bg_color cs post-relater-person">
								<a href="team-single.html" class="avatar">
									<img src="images/team/05-small.jpg" alt="">
								</a>
								<span class="playfair fontsize_22">
									<a href="#0">Roger Higgins</a>
								</span>
							</header>
							<div class="item-content">
								<div class="catogories-links highlight2links small-text medium">
									<a href="courses.html">Philosophy</a>
								</div>
								<h4 class="entry-title">
									<a href="course-sample.html">Motivate Yourself</a>
								</h4>
							</div>
							<footer class="item-meta bordered-meta greylinks">
								<div>
									<a href="#0">
										<i class="fa fa-users rightpadding_5" aria-hidden="true"></i>
										<span>3269</span>
									</a>
								</div>
								<div>
									<a href="#0">
										<i class="fa fa-comments rightpadding_5" aria-hidden="true"></i>
										<span>126</span>
									</a>
								</div>
								<div>
									<a href="#0">
										<i class="fa fa-money rightpadding_5" aria-hidden="true"></i>
										<span>550$</span>
									</a>
								</div>
							</footer>
						</div>

						<div class="vertical-item content-padding with_border">
							<div class="item-media">
								<img src="images/courses/06.jpg" alt="">
							</div>
							<header class="gradient_bg_color cs post-relater-person">
								<a href="team-single.html" class="avatar">
									<img src="images/team/06-small.jpg" alt="">
								</a>
								<span class="playfair fontsize_22">
									<a href="#0">Victor Bailey</a>
								</span>
							</header>
							<div class="item-content">
								<div class="catogories-links highlight2links small-text medium">
									<a href="courses.html">Astronomy</a>
								</div>
								<h4 class="entry-title">
									<a href="course-sample.html">Living In The Now Use It To</a>
								</h4>
							</div>
							<footer class="item-meta bordered-meta greylinks">
								<div>
									<a href="#0">
										<i class="fa fa-users rightpadding_5" aria-hidden="true"></i>
										<span>3269</span>
									</a>
								</div>
								<div>
									<a href="#0">
										<i class="fa fa-comments rightpadding_5" aria-hidden="true"></i>
										<span>126</span>
									</a>
								</div>
								<div>
									<a href="#0">
										<i class="fa fa-money rightpadding_5" aria-hidden="true"></i>
										<span>550$</span>
									</a>
								</div>
							</footer>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="cs parallax page_features section_padding_top_130 section_padding_bottom_100 columns_margin_bottom_30 container_padding_0 fluid_padding_0">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<div class="teaser text-center">
						<div class="teaser-icon size_big highlight2">
							<i class="fa fa-trophy" aria-hidden="true"></i>
						</div>
						<h3 class="counter" data-from="0" data-to="30" data-speed="2100">0</h3>
						<p>News Courses Every Years</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="teaser text-center">
						<div class="teaser-icon size_big highlight2">
							<i class="fa fa-university" aria-hidden="true"></i>
						</div>
						<h3 class="counter" data-from="0" data-to="28" data-speed="2100">0</h3>
						<p>Affiliates In All the States of America</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="teaser text-center">
						<div class="teaser-icon size_big highlight2">
							<i class="fa fa-graduation-cap" aria-hidden="true"></i>
						</div>
						<h3 class="counter" data-from="0" data-to="3720" data-speed="2100">0</h3>
						<p>Happy Graduates Per Year</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="teaser text-center">
						<div class="teaser-icon size_big highlight2">
							<i class="fa fa-users" aria-hidden="true"></i>
						</div>
						<h3 class="counter" data-from="0" data-to="874" data-speed="2100">0</h3>
						<p>Professional Teachers</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- PARTS::BEGIN BERITA SECTION -->
	<section class="ls section_padding_top_100 section_padding_bottom_100">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2 class="section_header highlight">
						Berita Terbaru
					</h2>
					<hr class="star_divider">
					<p class="fontsize_18">
						Example Text In Here
					</p>

					<div class="owl-carousel topmargin_60" data-responsive-lg="3" data-nav="true">
						<!-- PARTS::bagian isi berita -->
						<?php echo list_tab_post('berita-2', 5, 'img') ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- PARTS::END BERITA SECTION -->
	<!-- PARTS::BEGIN PENGUMUMAN -->
	<section class="space-pb">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 text-center">
					<div class="section-title">
						<h2>Pengumuman BKPSDM</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<?php echo list_tab_post_2('pengumuman', 3, 'img') ?>
				</div>
			</div>
		</div>
	</section>
	<!-- PARTS::END PENGUMUMAN -->
	<!-- PARTS::BEGIN  SPONSOR -->
	<section class="space-sm-pb clients-section-02">
		<div class="container">
			<div class="row our-clients align-items-center">
				<div class="col-lg-3 col-md-5 col-sm-6">
					<h4>Di Sponsori Oleh</h4>
				</div>
				<div class="col-lg-9 col-md-7 col-sm-6">
					<div class="owl-carousel testimonial-center owl-nav-bottom-center" data-nav-arrow="false" data-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-xx-items="1" data-space="40" data-autoheight="true">
						<div class="item">
							<img class="img-fluid center-block mx-auto" src="<?= base_url('themes/umk/assets2/images/client/01.svg') ?>" alt="">
						</div>
						<div class="item">
							<img class="img-fluid center-block mx-auto" src="<?= base_url('themes/umk/assets2/images/client/02.svg') ?>" alt="">
						</div>
						<div class="item">
							<img class="img-fluid center-block mx-auto" src="<?= base_url('themes/umk/assets2/images/client/03.svg') ?>" alt="">
						</div>
						<div class="item">
							<img class="img-fluid center-block mx-auto" src="<?= base_url('themes/umk/assets2/images/client/04.svg') ?>" alt="">
						</div>
						<div class="item">
							<img class="img-fluid center-block mx-auto" src="<?= base_url('themes/umk/assets2/images/client/05.svg') ?>" alt="">
						</div>
						<div class="item">
							<img class="img-fluid center-block mx-auto" src="<?= base_url('themes/umk/assets2/images/client/06.svg') ?>" alt="">
						</div>
						<div class="item">
							<img class="img-fluid center-block mx-auto" src="<?= base_url('themes/umk/assets2/images/client/07.svg') ?>" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- PARTS::END  SPONSOR -->

<?php } else { ?>
	<!-- Begin page content -->
	<?php echo $content; ?>
	<!--=================================
    banner -->

	<!--=================================
    Blog -->

	<div class="container-beranda">
		<div class="container bg_patern_h sdw">
			<?php if (isset($is_home)) { ?>
			<?php } ?>
			<div class="row">
				<?php if (isset($is_page)) { ?>
					<div class="col-lg-3 col-sm-3" style="margin-top:10px;padding-top:0px;">
						<!-- <div class="widget bg_primary" style="margin-bottom:10px;">
								<?php //echo get_search() 
								?>
							</div> -->
						<!-- <div id="sidebar">
								<?php //echo get_list_page(); 
								?>
							</div>
							<?php// get_sidebar1(); ?> -->
					</div>
				<?php } ?>
				<div class="col-lg-9 col-sm-9 bg_white">
					<!-- content -->
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php get_footer(); ?>