<div class="container container-stats">
	<div class="d-flex align-items-center justify-content-between flex-column flex-md-row">
		<ul class="list list-inline list-stats text-center text-md-left">
			<li><span class="list-stats-item icon icon-location icon-by-left" title="Местоположение">{{city}}</span></li>
			<li><span class="list-stats-item icon icon-age icon-by-left" title="Возраст">{{age}}</span></li>
			<li><span class="list-stats-item icon icon-expirience icon-by-left" title="Опыт работы">{{experience}}</span></li>
			<li><span class="list-stats-item icon icon-projects icon-by-left" title="Количество завершённых проектов">{{projects}}</span></li>
		</ul>
		
		{{#contacts}}
			{{#social.0}}
			<div class="contacts header-contacts mt-3 mt-md-0">
				<ul class="list list-inline contacts-social-list">
					{{#social}}<li><a href="{{link}}" target="_blank" class="icon icon-lg icon-{{code}}"></a></li>{{/social}}
				</ul>
			</div>
			{{/social.0}}
		{{/contacts}}
	</div>
</div>