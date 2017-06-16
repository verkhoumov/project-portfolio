/**
 *  Изменение Tooltip по нажатию.
 */
(function($) {
	$.fn.setTooltip = function(click_message, mouseout_message) {
		return this.each(function() {
			$(this)
				.attr('title', click_message)
				.tooltip('_fixTitle')
				.tooltip('show');

			if (typeof mouseout_message !== 'undefined') {
				$(this)
					.attr('title', mouseout_message)
					.tooltip('_fixTitle');
			}
		});
	};
}) (jQuery);

/**
 *  Копирование содержимого с помощью ClipboardJS.
 *  Проект: https://github.com/zenorocha/clipboard.js
 */
(function($) {
	$.fn.CopyToBuffer = function() {
		return this.each(function() {
			// Исходная подсказка.
			$(this).tooltip({
				title: 'Скопировать в буфер обмена',
				container: 'body',
				placement: 'top',
				animation: false
			});

			/**
			 *  Обработка Clipboard.
			 */
			// Подключение плагина.
			var clipboard = new Clipboard(this, {
				// Копируем содержимое контейнера.
				text: function(trigger) {
					var text = $(trigger).data('clipboardText');

					if (typeof text !== 'undefined') {
						return text;
					}

					return $(trigger).html();
				}
			});

			// Текст успешно скопирован.
			clipboard.on('success', function(e) {
				$(e.trigger).setTooltip('Скопировано!', 'Скопировать в буфер обмена');

				e.clearSelection();
			});

			// Произошла неизвестная ошибка, поэтому надо выделить
			// копируемое содержимое и вывести информацию о комбинации клавиш.
			clipboard.on('error', function(e) {
				var modifierKey = /Mac/i.test(navigator.userAgent) ? '\u2318+' : 'Ctrl+';
				var fallbackMsg = 'Нажмите ' + modifierKey + 'C';
				var target = $(e.trigger).data('clipboardTarget');

				$(e.trigger).setTooltip(fallbackMsg, 'Скопировать в буфер обмена');

				// Выделение текста в блоке.
				setTextSelection(typeof target !== 'undefined' ? $(target) : $(e.trigger));
			});
		});
	};
}) (jQuery);

/**
 *  Обработка полученного списка проектов и вывод на экран.
 */
(function($) {
	$.fn.addProjects = function(projects) {
		return this.each(function() {
			var $container = $(this);
			var projectsListTemp = {};

			// Копируем информацию для загрузки следующей страницы.
			projectsList.more = projects.more;

			// Запоминаем полученные проекты по годам.
			$.each(projects.projects, function(index, data) {
				projectsListTemp['+' + data.year] = data;
			});

			// Наполняем уже имеющиеся года новыми проектами.
			$.each(projectsList.projects, function(i1, data) {
				if (typeof projectsListTemp['+' + data.year] !== 'undefined') {
					$.each(projectsListTemp['+' + data.year].items, function(i2, item) {
						projectsList.projects[i1].items.push(item);
					});

					delete projectsListTemp['+' + data.year];
				}
			});

			// Добавляем проекты за старые года.
			$.each(projectsListTemp, function(index, data) {
				projectsList.projects.push(data);
			});

			// Генерируем новый макет.
			$container.html(
				$(Mustache.render(
					$('#template-projects').html(), 
					projectsList
				))
			);
		});
	};
}) (jQuery);