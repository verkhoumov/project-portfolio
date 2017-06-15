<div class="scrollspy" id="feedback">
	<div class="container-wrapper container-wrapper-feedback">
		<div class="container">
			<div class="row">
				<div class="offset-lg-1 col-lg-5 offset-xl-2 flex-lg-last">
					<div class="d-lg-flex align-content-lg-between flex-lg-wrap contacts">
						{{#contacts}}
							<div class="contacts-header">
								<h2>Контакты</h2>
								<p>По любым вопросам пишите мне на почту или в социальных сетях.</p>

								<ul class="list contacts-default-list">
									{{#default}}<li><span class="icon icon-{{code}} icon-by-left">{{name}}</span></li>{{/default}}
								</ul>
							</div>
							
							{{#social.0}}
							<div class="contacts-footer mt-4 mt-lg-0">
								<ul class="list list-inline contacts-social-list">
									{{#social}}<li><a href="{{link}}" target="_blank" class="icon icon-lg icon-{{code}}"></a></li>{{/social}}
								</ul>
							</div>
							{{/social.0}}
						{{/contacts}}
					</div>
				</div>

				<div class="col-lg-6 col-xl-5 flex-lg-first feedback mt-5 mt-lg-0">
					<h2>Обратная связь</h2>
					
					<div class="row">
						<div class="offset-sm-1 col-sm-10 offset-md-2 col-md-8 offset-lg-0 col-lg-12">
							<div class="wall">
								<form>
									<div class="form-group">
										<label for="feedbackName">Как Вас зовут?</label>
										<input type="text" class="form-control" name="feedback[name]" id="feedbackName" placeholder="Иван Петров" required>
									</div>

									<div class="form-group">
										<label for="feedbackEmail">Куда отправить ответ?</label>
										<input type="email" class="form-control" name="feedback[email]" id="feedbackEmail" placeholder="ivan.petrov@yandex.ru" required>
									</div>

									<div class="form-group">
										<label for="feedbackMessage">Текст сообщения</label>
										<textarea class="form-control" name="feedback[message]" id="feedbackMessage" placeholder="Привет! Хочу заказать разработку интернет-магазина, сколько это будет стоить?" required></textarea>
									</div>

									<button class="button button-primary" type="submit" name="feedback[submit]">Отправить</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>