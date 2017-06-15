{{#skills}}
<div class="scrollspy" id="skills">
	<div class="container-wrapper container-wrapper-skills">
		<div class="container">
			<h2 class="inverse">Навыки</h2>

			<div class="row hidden-sm-down">
				<div class="col-lg-12 col-xl-3">
					<div class="d-xl-flex align-content-xl-between flex-xl-wrap skills">
						<div class="skills-info">
							<p>Чтобы узнать уровень владения навыком, наведите на него или нажмите «Показать всё».</p>
						</div>

						<div class="skills-tools">
							<button class="button button-inverse icon icon-lg icon-eye icon-by-right" id="eye">Показать всё</button>
						</div>
					</div>
				</div>

				<div class="col-lg-12 col-xl-6 mt-5 mt-xl-0">
					<div class="skills-map-wrapper">
						<div class="d-flex align-items-center justify-content-center skills-map">
							<div class="skills-map-brain icon icon-brain">
								{{#main}}
								<div class="map-connector position-{{position}}">
									<div class="map-line">
										<div class="map-tech">
											<div class="image map-tech-image">
												<img src="{{image}}" alt="{{name}}">
											</div>

											<div class="map-tech-info">
												<span class="overflow">{{percent}}%</span>
												<a href="/projects?q={{code}}" class="overflow">{{projects}}</a>
											</div>
										</div>
									</div>
								</div>
								{{/main}}
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row hidden-md-up">
				<div class="col-12">
					<p>Перечень основных навыков.</p>
				</div>
				
				{{#main}}
				<div class="col-6 col-sm-4">
					<div class="skills-more-item">
						<div class="image skills-more-image">
							<img src="{{image}}" alt="{{name}}">
						</div>

						<div class="skills-more-info">
							<div class="d-flex justify-content-center skills-more-name">
								<span class="overflow">{{name}}</span>
								<span class="skills-more-percents">{{percent}}%</span>
							</div>

							<a href="/projects?q={{code}}" class="underline">{{projects}}</a>
						</div>
					</div>
				</div>
				{{/main}}
			</div>
		</div>
	</div>

	<div class="container-wrapper container-wrapper-skills-more">
		<div class="container">
			<div class="skills-more">
				<div class="row">
					{{#other}}
					<div class="col-6 col-sm-4 col-md-3 col-lg-2">
						<div class="skills-more-item">
							<div class="image skills-more-image">
								<img src="{{image}}" alt="{{name}}">
							</div>

							<div class="skills-more-info">
								<div class="d-flex justify-content-center skills-more-name">
									<span class="overflow">{{name}}</span>
									<span class="skills-more-percents">{{percent}}%</span>
								</div>

								<a href="/projects?q={{code}}" class="underline">{{projects}}</a>
							</div>
						</div>
					</div>
					{{/other}}

					<div class="col col-sm-8 col-md-6 col-lg-4">
						<div class="d-flex align-items-center skills-more-text">
							<p>Более {{experience}} опыта и {{count}} веб-разработки</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{/skills}}