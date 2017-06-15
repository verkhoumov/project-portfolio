<div class="container-wrapper container-wrapper-projects">
	<div class="container">
		{{&search}}
	
		<div class="portfolio search">{{&list}}</div>
		
		{{#portfolio.more.status}}
		<div class="portfolio-loader">
			<button class="button button-primary" data-last-date="{{portfolio.more.date}}" data-query-type="{{queryType}}" id="projects-more">Загрузить ещё проекты</button>
		</div>
		{{/portfolio.more.status}}
	</div>
</div>