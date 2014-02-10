;
(function ($) {
    var pluginName = 'selectric',
        emptyFn = function () {}, _replaceDiacritics = function (s) {
            var k, d = '40-46 50-53 54-57 62-70 71-74 61 47 77'.replace(/\d+/g, '\\3$&').split(' ');
            for (k in d)
                s = s.toLowerCase().replace(RegExp('[' + d[k] + ']', 'g'), 'aeiouncy'.charAt(k));
            return s;
        }, init = function (element, options) {
            var options = $.extend({
                onOpen: emptyFn,
                onClose: emptyFn,
                maxHeight: 300,
                keySearchTimeout: 500,
                arrowButtonMarkup: '<b class="button">&#9662;</b>',
                disableOnMobile: true,
                border: 1,
                openOnHover: false,
                expandToItemText: false
            }, options);
            if (options.disableOnMobile && /android|ip(hone|od|ad)/i.test(navigator.userAgent)) return;
            var $original = $(element),
                $wrapper = $('<div class="' + pluginName + '"><p class="label"/>' + options.arrowButtonMarkup + '</div>'),
                $items = $('<div class="' + pluginName + 'Items" tabindex="-1"></div>'),
                $outerWrapper = $original.data(pluginName, options).wrap('<div>').parent().append($wrapper.add($items)),
                selectItems = [],
                isOpen = false,
                $label = $('.label', $wrapper),
                $li, bindSufix = '.sl',
                $doc = $(document),
                $win = $(window),
                keyBind = 'keydown' + bindSufix,
                clickBind = 'click' + bindSufix,
                searchStr = '',
                resetStr, classOpen = pluginName + 'Open',
                classDisabled = pluginName + 'Disabled',
                tempClass = pluginName + 'TempShow',
                selectStr = 'selected',
                selected, currValue, itemsHeight, closeTimer, finalWidth;

            function _populate() {
                var $options = $('option', $original.wrap('<div class="' + pluginName + 'HideSelect">')),
                    _$li = '<ul>',
                    visibleParent = $items.closest(':visible').children(':hidden'),
                    maxHeight = options.maxHeight,
                    optionsLength, selectedElm = $options.filter(':' + selectStr);
                selected = selectedElm.index();
                currValue = selected;
                if (optionsLength = $options.length) {
                    $options.each(function (i) {
                        var $elm = $(this),
                            selectText = $elm.text(),
                            selectDisabled = $elm.prop('disabled');
                        selectItems[i] = {
                            value: $elm.val(),
                            text: selectText,
                            slug: _replaceDiacritics(selectText),
                            disabled: selectDisabled
                        };
                        _$li += '<li class="' + (i == selected ? selectStr : '') + (i == optionsLength - 1 ? ' last' : '') + (selectDisabled ? ' disabled' : '') + '">' + selectText + '</li>';
                    });
                    $items.html(_$li + '</ul>');
                    $label.text(selectItems[selected].text);
                }
                $wrapper.add($original).off(bindSufix);
                $outerWrapper.prop('class', pluginName + 'Wrapper ' + $original.prop('class') + ' ' + classDisabled);
                if (!$original.prop('disabled')) {
                    $outerWrapper.removeClass(classDisabled).hover(function () {
                        $(this).toggleClass(pluginName + 'Hover');
                    });
                    options.openOnHover && $wrapper.on('mouseenter' + bindSufix, _open);
                    $wrapper.on(clickBind, function (e) {
                        isOpen ? _close() : _open(e);
                    });
                    $original.on(keyBind, function (e) {
                        var key = e.which;
                        key != 9 && e.preventDefault();
                        if (/^(9|13|27)$/.test(key)) {
                            e.stopPropagation();
                            _select(selected, true);
                        }
                        clearTimeout(resetStr);
                        if (key < 37 || key > 40) {
                            var rSearch = RegExp('^' + (searchStr += String.fromCharCode(key)), 'i');
                            $.each(selectItems, function (i, elm) {
                                if (rSearch.test([elm.slug, elm.text]) && !elm.disabled)
                                    _select(i);
                            });
                            resetStr = setTimeout(function () {
                                searchStr = '';
                            }, options.keySearchTimeout);
                        } else {
                            searchStr = '';
                            _select(/^3(7|8)$/.test(key) ? previousEnabledItem(selected) : nextEnabledItem(selected));
                        }
                    }).on('focusin' + bindSufix, function (e) {
                        isOpen || _open(e);
                    });

                    function nextEnabledItem(idx, next) {
                        if (selectItems[next = (idx + 1) % optionsLength].disabled)
                            while (selectItems[next = (next + 1) % optionsLength].disabled) {}
                        return next;
                    }

                    function previousEnabledItem(idx, previous) {
                        if (selectItems[previous = (idx > 0 ? idx : optionsLength) - 1].disabled)
                            while (selectItems[previous = (previous > 0 ? previous : optionsLength) - 1].disabled) {}
                        return previous;
                    }
                    $li = $('li', $items.removeAttr('style')).click(function () {
                        _select($(this).index(), true);
                        return false;
                    });
                }
                visibleParent.addClass(tempClass);
                var wrapperWidth = $wrapper.outerWidth() - (options.border * 2);
                if (!options.expandToItemText || wrapperWidth > $items.outerWidth())
                    finalWidth = wrapperWidth;
                else {
                    $items.css('overflow', 'scroll');
                    $outerWrapper.width(9e4);
                    finalWidth = $items.outerWidth();
                    $items.css('overflow', '');
                    $outerWrapper.width('');
                }
                $items.width(finalWidth).height() > maxHeight && $items.height(maxHeight);
                visibleParent.removeClass(tempClass);
            }
            _populate();

            function _open(e) {
                e.preventDefault();
                e.stopPropagation();
                $('.' + classOpen + ' select')[pluginName]('close');
                isOpen = true;
                itemsHeight = $items.outerHeight();
                _isInViewport();
                var scrollTop = $win.scrollTop();
                e.type == 'click' && $original.focus();
                $win.scrollTop(scrollTop);
                $doc.on(clickBind, _close);
                if (options.openOnHover) {
                    clearTimeout(closeTimer);
                    $outerWrapper.off(bindSufix).on('mouseleave' + bindSufix, function () {
                        closeTimer = setTimeout(_close, 500);
                    });
                }
                $outerWrapper.addClass(classOpen);
                _detectItemVisibility(selected);
                options.onOpen(element);
            }

            function _isInViewport() {
                if (isOpen) {
                    $items.css('top', ($outerWrapper.offset().top + $outerWrapper.outerHeight() + itemsHeight > $win.scrollTop() + $win.height()) ? -itemsHeight : '');
                    setTimeout(_isInViewport, 100);
                }
            }

            function _close(e) {
                if (currValue != selected) {
                    $original.prop('selectedIndex', currValue = selected);
                    if (!e || e.type != 'click')
                        $original.change();
                }
                $doc.off(bindSufix);
                $label.text(selectItems[selected].text);
                $outerWrapper.removeClass(classOpen);
                isOpen = false;
                options.onClose(element);
            }

            function _select(index, close) {
                if (!selectItems[selected = index].disabled) {
                    $li.removeClass(selectStr).eq(index).addClass(selectStr);
                    _detectItemVisibility(index);
                    close && _close();
                }
            }

            function _detectItemVisibility(index) {
                var liHeight = $li.eq(index).outerHeight(),
                    liTop = $li[index].offsetTop,
                    itemsScrollTop = $items.scrollTop(),
                    scrollT = liTop + liHeight * 2;
                $items.scrollTop(scrollT > itemsScrollTop + itemsHeight ? scrollT - itemsHeight : liTop - liHeight < itemsScrollTop ? liTop - liHeight : itemsScrollTop);
            }
            $original.on({
                refresh: _populate,
                destroy: function () {
                    $items.add($wrapper).remove();
                    $original.removeData(pluginName).off(bindSufix + ' refresh destroy open close').unwrap().unwrap();
                },
                open: _open,
                close: _close
            });
        };
    $.fn[pluginName] = function (args, options) {
        return this.each(function () {
            if (!$(this).data(pluginName)) {
                init(this, args || options);
            } else if ('' + args === args) {
                $(this).trigger(args);
            }
        });
    };
}(jQuery));