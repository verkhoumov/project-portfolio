{{#projects}}
<div class="group">
	<div class="group-header">
		<span class="year">{{year}}</span>
		<a href="/projects?q={{year}}" class="count">{{count}}</a>
	</div>

	<div class="group-items">
		<div class="row">
			{{#items}}
			<div class="col-12 col-md-6 col-lg-4">
				<div class="group-project">
					<div class="d-flex justify-content-end group-project-bar">
						{{#progress}}<span class="progress" title="{{progress}}">{{percent}}%</span>{{/progress}}
						{{#personal}}<span class="personal icon icon-user" title="Личный проект"></span>{{/personal}}
					</div>

					<div class="d-flex justify-content-between align-items-center group-project-header">
						<a href="{{category_link}}" class="type">#{{category_name}}</a>
						<span class="date" title="Публичный релиз проекта">{{finished}}</span>
					</div>

					<div class="d-flex justify-content-start align-items-center group-project-body">
						<div class="image group-project-image">
							<img src="{{image}}" alt="{{name}}">
						</div>

						<a href="{{link}}">{{name}}</a>
					</div>

					<p class="group-project-description">{{description}}</p>
				</div>
			</div>
			{{/items}}
			
			{{#loadMore.status}}
			<div class="col-12 col-md-6 col-lg-4">
				<div class="group-more">
					<a href="/projects?q={{year}}" class="icon icon-more icon-lg icon-by-right">Показать ещё {{loadMore.count}}</a>
				</div>
			</div>
			{{/loadMore.status}}
		</div>
	</div>
</div>
{{/projects}}

{{^projects}}<p>Увы. Ни одного проекта не найдено. Попробуйте ещё раз используя другой запрос.</p>{{/projects}}