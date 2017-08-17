<div class="scrollspy" id="whyiam">
	<div class="container-wrapper container-wrapper-whyiam">
		<div class="container container-whyiam">
			<h2>Почему я?</h2>

			<div class="row align-items-center justify-content-between">
				<div class="col-12 col-lg-5">
					<div class="theses">
						{{#theses}}
						<div class="d-flex justify-content-start thesis">
							<span>{{position}}</span>

							<dl>
								<dt>{{title}}</dt>
								<dd>{{{text}}}</dd>
							</dl>
						</div>
						{{/theses}}
					</div>
				</div>

				<div class="col-12 col-lg-6 mt-5 mt-lg-0">
					<div class="video" id="whyiam-video">
						<div class="row align-items-center">
							<div class="col-12 col-sm-6">
								{{#video.1}}
								<div class="embed-responsive embed-responsive-16by9 clip mb-4 mb-sm-0" id="video-1">
									<div class="clip-wrapper">
										<div class="image clip-image">
											<img src="{{preview}}" alt="{{title}}">
										</div>

										<div class="d-flex justify-content-center align-items-center clip-info">
											<p>{{title}}</p>
											<span class="icon icon-play popup" data-video="{{video}}"></span>
										</div>

										<span class="clip-time">{{duration}}</span>
									</div>
								</div>
								{{/video.1}}
							</div>

							<div class="col-12 col-sm-6">
								<div class="row">
									<div class="col-12 col-sm-10">
										{{#video.2}}
										<div class="embed-responsive embed-responsive-16by9 clip mb-4" id="video-2">
											<div class="clip-wrapper">
												<div class="image clip-image">
													<img src="{{preview}}" alt="{{title}}">
												</div>

												<div class="d-flex justify-content-center align-items-center clip-info">
													<p>{{title}}</p>
													<span class="icon icon-play popup" data-video="{{video}}"></span>
												</div>

												<span class="clip-time">{{duration}}</span>
											</div>
										</div>
										{{/video.2}}
									</div>

									<div class="col-12">
										{{#video.3}}
										<div class="embed-responsive embed-responsive-16by9 clip" id="video-3">
											<div class="clip-wrapper">
												<div class="image clip-image">
													<img src="{{preview}}" alt="{{title}}">
												</div>

												<div class="d-flex justify-content-center align-items-center clip-info">
													<p>{{title}}</p>
													<span class="icon icon-play popup" data-video="{{video}}"></span>
												</div>

												<span class="clip-time">{{duration}}</span>
											</div>
										</div>
										{{/video.3}}
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center">
						<div class="col-8">
							<p class="tip">Разбор ошибок некоторых популярных веб-сайтов и сервисов.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>