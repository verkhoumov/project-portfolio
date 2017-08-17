$(document).ready(function() {
	/**
	 *  Всплывающие подсказки.
	 */
	$('[title]')
		.tooltip({
			container: 'body',
			placement: 'top',
			animation: true
		});

	/**
	 *  Скроллбар.
	 */
	$('.scrollbar').is(function() {
		$(this)
			.perfectScrollbar({
				suppressScrollX: true
			})
			.perfectScrollbar('update');

		return true;
	});

	/**
	 *  Показать/Скрыть информацию о навыках на карте.
	 */
	$(document).on('click', '#eye', function() {
		if ($(this).hasClass('icon-eye')) {
			$(this)
				.removeClass('icon-eye')
				.addClass('icon-eye-close')
				.text('Скрыть');

			$('.map-tech').addClass('active');
		} else {
			$(this)
				.removeClass('icon-eye-close')
				.addClass('icon-eye')
				.text('Показать всё');

			$('.map-tech').removeClass('active');
		}
	});

	// Навигация.
	var $header = $('header'),
		headerH = $header.height(),
		headerY = $header.offset().top,
		windowH = $(window).height(),
		windowW = $(window).width(),
		defaultMenuH = 66,
		menuH = defaultMenuH,
		$dropdown = $('.dropdown'),
		scrollspyBlocks = [];

	// Добавляем главный пункт меню.
	scrollspyBlocks.push({
		href: '/',
		position: 0
	});

	// Добавляем остальные пункты.
	$('.scrollspy').each(function() {
		scrollspyBlocks.push({
			href: '#' + $(this).attr('id'),
			position: $(this).offset().top - menuH
		});
	});

	// Разворачиваем массив, чтобы проводить проверку 
	// начиная с последних блоков.
	scrollspyBlocks.reverse();

	// Отслеживание пунктов меню.
	var status = false;

	// Навыки.
	var $skills = $('.container-wrapper-skills');

	if ($skills.is('*')) {
		var $skillsMap = $('.skills-map'),
			skillsOffsetY =  $skills.offset().top,
			skillsH = $skills.innerHeight();
	}

	// Видео-ролики.
	var $video = $('#whyiam-video');

	if ($video.is('*')) {
		var videoH = $video.innerHeight(),
			videoTop = $video.offset().top,
			videoBottom = videoTop + videoH,
			videoPos = {
				'1': {
					right: 45
				},
				'2': {
					bottom: 45,
					left: 60
				},
				'3': {
					left: 25,
					top: 35
				}
			};
	}

	// Скроллинг страницы (несколько разных обработчиков).
	$(window).on('load scroll', function() {
		// Позиция скролла.
		var scrollY = $(this).scrollTop();

		/**
		 *  Изменение типа меню при прокрутке страницы.
		 */
		if (scrollY >= (headerH + headerY - menuH)) {
			$header.addClass('fixed-padding');

			if (!$dropdown.hasClass('active') && !$header.hasClass('fixed')) {
				$header.addClass('fixed').fadeOut(0).fadeIn(300);
				$('body').css('padding-top', headerH);
			}
		} else {
			$header.removeClass('fixed-padding');

			if (!$dropdown.hasClass('active') && $header.hasClass('fixed')) {
				$('header').removeClass('fixed');
				$('body').css('padding-top', 0);
			}
		}

		/**
		 *  Отслеживание активного пункта меню.
		 */
		if (scrollspyBlocks.length > 1) {
			$('nav li').removeClass('active');

			$.each(scrollspyBlocks, function(index, block) {
				if (scrollY >= block.position) {
					$('nav a[href="' + block.href + '"]').parent('li').addClass('active');

					// Прекращаем дальнейшие проверки.
					return false;
				}
			});
		}

		/**
		 *  Активация карты навыков.
		 */
		if (scrollY + (windowH * 0.40) > skillsOffsetY && 
			scrollY + (windowH * 0.60) < skillsOffsetY + skillsH &&
			!$skillsMap.hasClass('active')) {
			$skillsMap.addClass('active');
		}

		/**
		 *  Смещение видео-роликов при приблежении к ним. Работает только при ширине экрана
		 *  более 576 пикселей, чтобы на мобильных устройствах не появлялся горизонтальный скролл.
		 */
		if (videoTop > 0 && windowW > 576) {
			var windowBottom = scrollY + windowH,
				windowMiddle = scrollY + windowH / 2,
				resize = 1;

			// Сводим видеоролики.
			if (windowBottom >= videoTop && windowMiddle <= videoTop) {
				resize = (videoTop - windowMiddle) / (windowH / 2);
			}

			// Держим ролики сведёнными.
			if (windowMiddle > videoTop && windowMiddle < videoBottom) {
				resize = 0;
			}

			// Разводим видеоролики.
			if (videoBottom <= windowMiddle && videoBottom >= scrollY) {
				resize = 1 - (((videoBottom + windowH / 2) - windowMiddle) / (windowH / 2));
			}

			// Нормализуем коэффициент.
			resize = resize > 1 ? 1 : (resize > 0 ? resize : 0);

			// Положение каждого ролика.
			$('#video-1').css({
				right: (videoPos[1].right * resize) + 'px'
			});

			$('#video-2').css({
				bottom: (videoPos[2].bottom * resize) + 'px',
				left: (videoPos[2].left * resize) + 'px'
			});

			$('#video-3').css({
				top: (videoPos[3].top * resize) + 'px',
				left: (videoPos[3].left * resize) + 'px'
			});

			// Прозрачность.
			$('#video-1, #video-2, #video-3').css({
				opacity: (1 - resize)
			});
		}
	});

	/**
	 *  Прокрутка страницы до заданной области.
	 */
	$(document).on('click', '.scrolling', function(event) {
		var target,
			dataTarget = $(this).data('target'),
			attrHref = $(this).attr('href');

		if (typeof dataTarget !== 'undefined') {
			target = dataTarget;
		} else if (typeof attrHref !== 'undefined' && attrHref !== false) {
			target = attrHref;
		}

		$(target).is(function() {
			// Отменяем переход по ссылке.
			event.preventDefault();

			// Прокручиваем страницу к нужному месту.
			scrollToTarget(target);

			return true;
		});
	});

	/**
	 *  Magnific-Popup.
	 */
	$(document).on('click', '.popup', function() {
		var video = $(this).data('video');

		$(this)
			.magnificPopup({
				items: {
					src: video
				},
				type: 'iframe'
			})
			.magnificPopup('open');
	});

	/**
	 *  Активация выпадающего меню.
	 */
	$(document).on('click', '#dropdown-button', function() {
		if (!$dropdown.hasClass('active')) {
			$dropdown.addClass('active');

			if (!$header.hasClass('fixed')) {
				$header.addClass('fixed').fadeOut(0).fadeIn(300);
				$('body').css('padding-top', headerH);
			}
		} else {
			var scrollY = $(window).scrollTop();

			$dropdown.removeClass('active');

			if (scrollY < (headerH + headerY - menuH)) {
				$('header').removeClass('fixed');
				$('body').css('padding-top', 0);
			}
		}
	});

	/**
	 *  Подсветка кода.
	 */
	if (typeof hljs !== 'undefined') {
		var code = {};

		// Настройка плагина.
		hljs.configure({
			tabReplace: '   ',
		});

		// Подключение плагина к вставкам с программным кодом.
		$('pre code').each(function(i, block) {
			// Копируем программный код.
			code[i] = $(block).text();

			// Присваиваем блоку ID.
			$(block).parent().data('codeId', i);

			// Включаем подсветку кода.
			hljs.highlightBlock(block);
		});

		$('pre').each(function(i, block) {
			// Добавление скроллбара для прокрутки больших вставок кода.
			$(block)
				.perfectScrollbar()
				.perfectScrollbar('update');

			// Оборачиваем код.
			var $wrapper = $('<div></div>').addClass('pre-wrapper');
			$(block).wrap($wrapper);

			// Создаём кнопку "Скопировать".
			var $copyButton = $('<span></span>').addClass('clipboard-code').text('Скопировать');
			$(block).parent().prepend($copyButton);

			// Присваиваем программный код.
			$copyButton.data('clipboardText', code[$(block).data('codeId')]);
			$copyButton.data('clipboardTarget', $copyButton.next('pre').find('code'));
		});

		// При нажатии на созданную кнопку копируем исходный код.
		$('.clipboard-code').CopyToBuffer();
	}

	/**
	 *  Кнопка очистки формы и запроса.
	 *
	 *  Если пользователь находится не на главной странице поиска,
	 *  то его перекинет на главную, в противном случае будет просто
	 *  очищена форма от введённых символов.
	 */
	$('.search .form-control').is(function() {
		var $form = $(this),
			$reset = $('.search .reset-button');

		// Функция для проверки формы.
		var searchFormChecker = function() {
			// Скрываем кнопку перед проверкой.
			$reset.removeClass('active');

			if (getQueryString() == null) {
				if ($form.val().length > 0) {
					$reset.addClass('active');
				}
			} else {
				$reset.addClass('active');
			}
		};

		$reset.on('click', function(e) {
			if (getQueryString() == null) {
				e.preventDefault();
				$form.val('');
				searchFormChecker();
			}
		});

		// Проверка формы при изменении.
		$form.on('change keyup', function() {
			searchFormChecker();
		}).trigger('change');

		return true;
	});

	/**
	 *  Копирование содержимого.
	 */
	$('.clipboard').CopyToBuffer();

	/**
	 *  AJAX-обработчик загрузки проектов.
	 */
	$(document).on('click', '#projects-more:not(:disabled)', function() {
		var self = this;

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '/ajax/projects/get',
			timeout: 3000,
			data: {
				query: getQueryString(),
				queryType: $(self).data('queryType'),
				lastDate: $(self).data('lastDate')
			},
			beforeSend: function() {
				// Выводим индикатор выполнения запроса.
				$('.portfolio').addClass('loading');
				$(self).attr('disabled', 'disabled');
			},
			error: function() {
				alert('Во время загрузки проектов что-то пошло не так...');
			},
			success: function(json) {
				var status = 400,
					data = {};

				if (typeof json.status !== 'undefined') {
					status = json.status;
				}

				if (typeof json.data !== 'undefined') {
					data = json.data;
				}

				if (status == 200) {
					// Обрабатываем кнопку "Загрузить ещё проекты".
					if (data.more.status === true) {
						$(self).data('lastDate', data.more.date);
					} else {
						$(self).remove();
					}

					// Выгружаем список проектов.
					$('.portfolio').addProjects(data);
				} else {
					alert('Во время загрузки проектов что-то пошло не так...');
					console.log('Во время выполнения запроса произошла ошибка: ', status);
				}
			},
			complete: function() {
				// Убираем индикатор выполнения запроса.
				$('.portfolio').removeClass('loading');
				$(self).removeAttr('disabled');
			}
		});
	});

	/**
	 *  AJAX-обработчик формы обратной связи.
	 */
	$(document).on('submit', '.feedback form', function(e) {
		var self = this;

		var $form = $(self),
			$wall = $(self).parent('.wall'),
			$button = $wall.find('.button');

		// Отменяем стандартную отправку.
		e.preventDefault();

		// Удаляем старые алерты.
		$wall.find('.alert').remove();

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '/ajax/feedback',
			timeout: 3000,
			data: $form.serialize(),
			beforeSend: function() {
				// Выводим индикатор выполнения запроса.
				$wall.addClass('loading');
				$button.attr('disabled', 'disabled');
			},
			error: function() {
				alert('Во время отправки сообщения что-то пошло не так...');
			},
			success: function(json) {
				var status = 400,
					errors = {};

				if (typeof json.status !== 'undefined') {
					status = json.status;
				}

				if (typeof json.errors !== 'undefined') {
					errors = json.errors;
				}

				if (status == 200) {
					// Создаём новый блок с ошибкой.
					var $alert = $('<div></div>').addClass('alert alert-success mb-4').text('Ваше сообщение было успешно отправлено! Ответ будет выслан Вам в ближайшие 24 часа!');

					// Вставляем после поля.
					$wall.prepend($alert);

					// Очищаем форму.
					$form[0].reset();
				} else {
					console.log('Во время выполнения запроса произошла ошибка: ', status);

					// Выводим ошибки над полями.
					$.each(errors, function(index, value) {
						// Создаём новый блок с ошибкой.
						var $alert = $('<div></div>').addClass('alert alert-input alert-error').text(value);

						// Вставляем после поля.
						$form.find('[name="feedback[' + index + ']"]').before($alert);
					});

					// Проверяем количество ошибок формы.
					var errorsCount = Object.keys(errors).length || 0;

					if (!errorsCount) {
						alert('Во время отправки сообщения что-то пошло не так...');
					}
				}
			},
			complete: function() {
				// Убираем индикатор выполнения запроса.
				$wall.removeClass('loading');
				$button.removeAttr('disabled');
			}
		});
	});

	/**
	 *  Защита от спама.
	 */
	var formSecurity = false;

	$(document).on('mousemove', '.feedback form', function() {
		if (formSecurity) {
			return;
		}

		// Фиксируем проверку.
		formSecurity = true;

		// Добавляем секретное поле.
		$(this).prepend('<input type="hidden" name="feedback[security]" value="success">');
	});

	/**
	 *  Автоувеличение формы textarea.
	 */
	autosize($('textarea'));

	/**
	 *  Кнопка "Наверх".
	 */
	var scrollToTopPosition = 0;

	// Изменение состояния кнопки "Наверх", когда она находится в 
	// режиме возврата и экран прокручен дальше шапки сайта.
	var changeScrollToTopState = function() {
		if ($(this).scrollTop() > headerH) {
			// Снимаем режим возврата с кнопки.
			$('.scroll-to-top').removeClass('return').find('b')
				.removeClass('icon-down')
				.addClass('icon-up')
				.text('Наверх');

			// Очищаем исходную позицию прокрутки.
			scrollToTopPosition = 0;

			// Удаляем обработчик скроллинга, он больше не нужен.
			$(this).off('scroll', changeScrollToTopState);
		}
	};

	// Обработчик нажатия.
	$(document).on('click', '.scroll-to-top', function() {
		var $button = $(this);

		// Кнопка "Назад".
		if ($button.hasClass('return')) {
			// Прокручиваем на старое место.
			scrollToPosition(scrollToTopPosition, false, function() {
				// Удаляем класс возврата.
				$button.removeClass('return').find('b')
					.removeClass('icon-down')
					.addClass('icon-up')
					.text('Наверх');

				// Очищаем исходную позицию прокрутки.
				scrollToTopPosition = 0;
			});
		} else {
			// Запоминаем текущую позицию.
			scrollToTopPosition = $(window).scrollTop();

			// Добавляем специальный класс для возврата.
			$button.addClass('return');

			// Прокручиваем в начало страницы.
			scrollToPosition(0, false, function() {
				$button.find('b')
					.removeClass('icon-up')
					.addClass('icon-down')
					.text('');

				// Вешаем обработчик, который делает кнопку умной.
				$(window).on('scroll', changeScrollToTopState);
			});
		}
	});
});