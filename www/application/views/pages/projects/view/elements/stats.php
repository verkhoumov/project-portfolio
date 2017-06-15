<div class="container container-stats">
	<ul class="list list-inline list-stats text-center text-md-left">
		{{#progress}}<li><span class="list-stats-item icon icon-progress icon-by-left" title="{{progress}}">{{percent}}%</span></li>{{/progress}}
		{{#personal}}<li><span class="list-stats-item icon icon-personal icon-by-left" title="Данный проект выполнен в личных интересах">Личный проект</span></li>{{/personal}}
		{{#started}}<li><span class="list-stats-item icon icon-start icon-by-left" title="Начало разработки">{{started}}</span></li>{{/started}}
		{{#finished}}<li><span class="list-stats-item icon icon-finish icon-by-left" title="Публичный релиз проекта">{{finished}}</span></li>{{/finished}}
		{{#github}}<li><a href="{{github}}" target="_blank" class="list-stats-item icon icon-github-sm icon-by-left" title="Проект на GitHub"><span>{{githubName}}</span></a></li>{{/github}}
	</ul>
</div>