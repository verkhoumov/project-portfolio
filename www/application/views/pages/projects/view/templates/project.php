<div class="container-wrapper container-wrapper-project">
	<div class="container">
		<div class="project">
			<div class="row">
				<div class="col-12 col-lg-8">
					<div class="project-header"></div>
					<div class="project-body">{{{text}}}</div>
				</div>

				<div class="col-12 col-lg-4">
					<div class="project-side">
						<div class="example">
							<h3>Демо-доступ</h3>
							
							<ul class="list example-list">
								<li class="overflow">Ссылка: <a href="#" class="underline" target="_blank">https://verkhoumov.ru/projects/portfolio/DimaPchenKrutoiParen</a></li>
								<li>Логин: <b class="clipboard">admin</b></li>
								<li>Пароль: <b class="clipboard">admin</b></li>
							</ul>
						</div>

						{{#techs.0}}
						<div class="techs">
							<h3>Технологии</h3>

							<ul class="list list-inline techs-list">
								{{#techs}}<li><a href="/projects?q={{code}}" style="background: {{color}};">{{name}}</a></li>{{/techs}}
							</ul>
						</div>
						{{/techs.0}}
						
						{{#files.0}}
						<div class="files">
							<h3>Документы и файлы</h3>

							<ul class="list files-list">
								{{#files}}<li><a href="{{link}}" target="_blank">{{name}}<span class="file file-{{type}}">.{{type}}</span></a></li>{{/files}}
							</ul>
						</div>
						{{/files.0}}
						
						<div class="tags">
							<h3>Метки</h3>

							<ul class="list list-inline tags-list">
								<li><a href="{{info.category_link}}">{{info.category_name}}</a></li>{{#tags}}<li><a href="/projects?q={{code}}" title="{{tooltip}}">{{name}}</a></li>{{/tags}}
							</ul>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-8">
					<div class="project-footer">
						<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
						<script src="//yastatic.net/share2/share.js"></script>

						<div class="d-flex justify-content-center align-items-center flex-column flex-md-row wall wall-sm share">
							<p class="text-center text-md-left">Если Вам понравился проект, поделитесь ссылкой на него: </p>
							<div class="mt-2 mt-md-0 ya-share2" data-services="vkontakte,facebook,odnoklassniki,gplus,twitter" data-title="{{info.title}}" data-description="{{info.description}}" data-image="{{info.image}}"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>