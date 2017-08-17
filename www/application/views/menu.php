<div class="container container-navigation">
	<div class="row align-items-md-start align-items-lg-center">
		<div class="col">
			<div class="dropdown d-block d-lg-none">
				<div class="d-flex justify-content-between">
					<button class="button button-menu icon icon-menu" id="dropdown-button"></button>

					<div>
						<a href="/projects" class="button button-default">Проекты</a>
						<a href="#feedback" class="button button-primary icon icon-send icon-by-left scrolling d-none d-sm-inline-block">Написать</a>
					</div>
				</div>
			</div>

			<nav>
				<ul class="list list-inline">
					<li class="navigation-author-image">
						<a href="/">
							<span class="image author-image-small">
								<img src="{{image}}" width="100" height="100" alt="{{name}}, {{profession}}">
							</span>
						</a>
					</li>
					<li class="active"><a href="/">Главная</a></li>
					<li><a href="#about" class="scrolling">Обо мне</a></li>
					<li><a href="#skills" class="scrolling">Навыки</a></li>
					<li><a href="#portfolio" class="scrolling">Портфолио</a></li>
					<li><a href="#whyiam" class="scrolling">Почему я?</a></li>
					<li><a href="#feedback" class="scrolling">Контакты</a></li>
				</ul>
			</nav>
		</div>

		<div class="col col-auto d-none d-lg-block">
			<a href="/projects" class="button button-default">Проекты</a>
		</div>

		<div class="col col-auto d-none d-lg-block">
			<a href="#feedback" class="button button-primary icon icon-send icon-by-left scrolling">Написать</a>
		</div>
	</div>
</div>