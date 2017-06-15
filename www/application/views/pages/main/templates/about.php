<div class="scrollspy" id="about">
	<div class="container-wrapper container-wrapper-about">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-5">
					<h2>Обо мне</h2>
					
					<div class="history-wrapper">
						<div class="history scrollbar">
							<div class="history-list">
								{{#history}}
								<div class="d-flex justify-content-start history-item">
									<h3>{{year}}</h3>
									<p>{{{text}}}</p>
								</div>
								{{/history}}
							</div>
						</div>
					</div>
				</div>

				<div class="offset-md-1 col-md-5 offset-lg-2 mt-5 mt-md-0">
					<h2>Образование</h2>

					<div class="education">
						{{#education}}
						<div class="education-item">
							<p class="education-period">{{started}} — {{finished}}</p>
							
							<div class="d-flex justify-content-start">
								<div class="image education-university-logotype">
									<img src="{{image}}" alt="{{name}}">
								</div>

								<div class="education-university-info">
									<h3>{{name}}</h3>
									<p class="education-university-facultet">{{faculty}}</p>
									<p class="education-university-city">{{city}}</p>

									<h3>Специализация:</h3>
									<p class="education-university-profession">{{specialization}}</p>
								</div>
							</div>
						</div>
						{{/education}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>