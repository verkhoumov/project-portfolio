/**
 *  Функция для плавной прокрутки страницы до заданного элемента.
 */
var scrollToPosition = function(position, addMenuH, callback) {
	// Настройки.
	var speed = 4,
		scrollY = $(window).scrollTop(),
		menuH = addMenuH ? $('header.fixed').innerHeight() || 66 : 0;

	// Информация о месте назначения.
	var destY = position - menuH;

	// Скорость прокрутки.
	var speed = Math.floor(Math.abs(scrollY - destY) / speed);

	// Инициализация скроллинга.
	$('body').animate({
		scrollTop: destY
	}, speed, function() {
		if (typeof callback === 'function') {
			callback();
		}
	});
};

var scrollToTarget = function(target) {
	if (typeof target === 'undefined') {
		return false;
	}

	return $(target).is(function() {
		scrollToPosition($(this).offset().top, true);
		return true;
	});
};

/**
 *  Выделение текста внутри указанного блока.
 */
var setTextSelection = function(target) {
	var range, selection;

	if (document.createRange) {
		range = document.createRange();
		range.selectNode(target[0])
		selection = window.getSelection();
		selection.removeAllRanges();
		selection.addRange(range);
	} else {
		var range = document.body.createTextRange();
		range.moveToElementText(target[0]);
		range.select();
	}
};

/**
 *  Обрабатывает строку запроса, определяя значение параметра `q`=?.
 */
var getQueryString = function() {
	var search = location.search.substring(1) || null;
	var query = null;

	if (search !== null) {
		var searchArray = search.split('=');

		if (searchArray.length == 2 && searchArray[0] == 'q' && searchArray[1] != '') {
			// Декодирование переводит кириллицу в читаемый вид.
			query = decodeURIComponent(searchArray[1]);
		}
	}

	return query;
};