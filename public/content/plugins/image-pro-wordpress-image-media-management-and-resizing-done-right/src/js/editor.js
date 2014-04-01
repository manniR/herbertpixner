(function($) {

    /* the minimum width and height to which images can be resized */
    var MIN_W = 30;
    var MIN_H = 30;

    /* references to jQuery elements */
    var $editor, $imgSize, $imgW, $imgH, $imgMaxW;
    var $clickedImage;

    /* the maximum width imposed by the current theme, if applicable */
    var themeMaxWidth;

    var init = function() {
        /* set a reference to the image editor and other elements */
        $editor = $('#impro_editor');
        $imgSize = $('#impro-editor-size');
        $imgW = $('#impro-editor-w');
        $imgH = $('#impro-editor-h');
        $imgMaxW = $('#impro-editor-maxwidth');

        /* start with the editor closed */
        $('#impro_editor_box').addClass('closed').find('.handlediv').hide();

        /* init events */
        initEvents();

        /* if the visual editor is enabled in the user preferences */
        if ($('#edButtonPreview').size() > 0 || $('#content-tmce').size() > 0) {
            /* hook up the switchEditors to find out when the editor is changed */
            /* TODO: This does not work for WordPress 3.2 */
            try {
                switchEditors.old_go = switchEditors.go;
                switchEditors.go = function(id, mode) {
                    switchEditors.old_go(id, mode);
                    onSwitchEditor(id, mode);
                };
            } catch(ex) {}

            /* tinyMCE will start initialization soon */
            var tinymceInitTimer = setInterval(function() {
                if (window.tinymce && window.tinymce.getInstanceById('content')) {
                    clearInterval(tinymceInitTimer);

                    /* prevent the user opening the image settings panel */
                    $('#impro_editor_box').find('.hndle').unbind('click');

                    /* initialize the editor */
                    onEditorInit(window.tinymce.getInstanceById('content'));
                }
            }, 300);
        } else {
            impro.err(imageproEditorL10N.enableTinyMce);
        }
    };

    var getTinyMCE = function() {
        return tinymce.getInstanceById('content');
    };

    var onEditorInit = function(editor) {
        /* now waiting for the iframe inside to render the post and have the body */
        var timer = setInterval(function() {
            var $body = $(getTinyMCE().contentAreaContainer).find('iframe').contents().find('body');
            if ($body.length) {
                clearInterval(timer);

                /* link the click event to tiny mce */
                setTinyMCEInteractions($body, getTinyMCE());

                /* if we are re on Chrome or Safari, try to simulate the resize handles */
                if (window.tinymce.isWebKit) {
                    impro.fakeImageResize();
                }
            }
        }, 300);
    };

    var setTinyMCEInteractions = function(body, editor) {

        /* get max width for images, if set by the WordPress theme */
        themeMaxWidth = getThemeMaxWidth(body);
        if ('number' !== typeof themeMaxWidth) {
            /* if the theme is not responsive, the responsiveness checkbox should be hidden */
            $('#impro-editor-maxwidth-container').hide();
        } else {
            $('#impro-editor-maxwidth-info').html($('#impro-editor-maxwidth-info').html().replace('%maxwidth%', themeMaxWidth));
        }

        /* register drop event to catch drops */
        setInterval(function() {
            /* because the ondrop event is not at all reliable
             * not to say about its cross browser support,
             * I used a interval checking (polling) */
            var body = editor.dom.doc.body;
            var thumbs = $(body).find('img[src*="\\/thumb\\/phpThumb\\.php"]');

            if (thumbs.size() > 0) {
                thumbs.each(function(i) {
                    /* get source image */
                    var thumb_w = $(this).width();
                    var thumb_h = $(this).height();

                    var src = $(this).attr('src');
                    var pic_src;

                    /* get picture source */
                    var match = /\/thumb\/phpThumb\.php\?.*?&src=([^&]*)&?/i.exec(src);
                    if (match != null) {
                        pic_src = match[1];
                    }

                    /* apply picture source and dimensions */
                    if (pic_src) {
                        $(this).attr('src', pic_src).attr('data-mce-src', pic_src).attr('_mce_src', pic_src);
                        $(this).attr('width', thumb_w).attr('data-mce-width', thumb_w).attr('_mce_width', thumb_w);
                        $(this).attr('height', thumb_h).attr('data-mce-height', thumb_h).attr('_mce_height', thumb_h);

                        /* open the editor, for the last one
                         in theory, it should be JUST one, but if the user is fast enough
                         to drag more, we should only open the editor for one, in order
                         not to slow down the UI
                         we open the editor by simulating a mouseup on the image */
                        if (thumbs.length - 1 === i) {
                            var outerThis = this;
                            setTimeout(function() {
                                $(outerThis).trigger(impro.minIE10 ? 'mousedown' : 'click');
                            }, 100);
                        }
                    }
                });
            }
        }, 300);

        /* set the click event on body, then limit by images */
        body.bind(impro.minIE10 ? 'mousedown' : 'click', function(ev) {
            var target = $(ev.target);
            /* only process image clicks */
            if (target.is('img')) {
                showEditor(target);
            } else {
                closeEditor();
            }
            return true;
        });
    };

    var openEditor = function() {
        $('#impro_editor_box').removeClass('closed');
    };

    var closeEditor = function() {
        $('#impro_editor_box').addClass('closed');
    };

    /**
     * populates the editor in the right with the properties of the currently selected image
     * @param target the clicked image, as a jQuery element
     */
    var showEditor = function(target) {

        var currentSrc = $(target).attr('src');
        var currentDomain = document.location.protocol + '//' + document.location.host;

        /* if the image begins with http://my.domain/, it was uploaded with classic wordpress upload,
        or it was just moved around the document so it got a http:// at the beginning */
        if (0 === currentSrc.indexOf(currentDomain + '/')) {
            currentSrc = currentSrc.replace(currentDomain, '');
            target.attr('src', currentSrc).attr('data-mce-src', currentSrc).attr('_mce_src', currentSrc);
        }

        /* if does not begin with /, it means it is from an external domain */
        if (currentSrc[0] != "/") {
            impro.err(imageproEditorL10N.differentDomain);
            return;
        }

        /* open the editor panel */
        openEditor();

        /* remember the clicked image (currently in editor) */
        $clickedImage = target;

        /* remove the inline styles */
        $clickedImage.css('width', '');
        $clickedImage.css('height', '');
        $clickedImage.removeAttr('data-mce-style');

        /* remember the old source */
        $clickedImage.data('oldSrc', target.attr('src'));

        /* show thumb image in the panel to the right */
        $('#impro-preview').css({
            'background-image': 'url("' + target.attr('src') + '")'
        });

        /* set alt and title */
        $('.impro_alt').val(target.attr('alt'));
        $('.impro_title').val(target.attr('title'));

        /* set align mode */
        var align = "alignnone";
        if (target.hasClass('alignleft')) {
            align = "alignleft";
        } else if (target.hasClass('aligncenter')) {
            align = "aligncenter";
        } else if (target.hasClass('alignright')) {
            align = "alignright";
        }
        $('.impro_align').val(align);

        /* set link */
        if ($clickedImage.parent().is('a[href]')) {
            $('.impro_link').attr('checked', 'checked');
        } else {
            $('.impro_link').removeAttr('checked');
        }

        /* decide if responsiveness checkbox should be displayed */
        var hasInlineMaxWidthNone = /max-width\s*:\s*none/.test(target[0].style.cssText);

        /* if this image has a responsiveness setting attached */
        if (hasInlineMaxWidthNone || 'number' === typeof themeMaxWidth) {
            $('#impro-editor-maxwidth').show();
            if (hasInlineMaxWidthNone) {
                $('#impro-editor-maxwidth').attr('checked', 'checked');
            } else {
                $('#impro-editor-maxwidth').removeAttr('checked');
            }
        } else {
            $('#impro-editor-maxwidth').hide();
        }

        /* set the size preset */
        selectCorrectPreset($clickedImage.attr('width'), $clickedImage.attr('height'));

        /* set the height and width */
        $imgW.val($clickedImage.attr('width'));
        $imgH.val($clickedImage.attr('height'));
    };

    /* updates the image preset select box with the correct setting depending on the image size */
    var selectCorrectPreset = function(w, h) {
        /* set the size preset */
        var fullWidth = $clickedImage[0].naturalWidth;
        var fullHeight = $clickedImage[0].naturalHeight;

        /* the value to select at the end */
        var valueToSelect;

        /* if the image is the full size */
        if (fullWidth == w && fullHeight == h) {
            valueToSelect = '__full';
        }

        /* if not yet chosen */
        if (!valueToSelect) {
            /* search among the presets */
            $imgSize.find('option[data-preset-width]').each(function() {
                var presetWidth = parseInt($(this).attr('data-preset-width'), 10);
                if (presetWidth == w) {
                    valueToSelect = $(this).attr('value');
                    return false;
                }
            });
        }

        /* if not yet chosen */
        if (!valueToSelect) {
            if ('number' === typeof themeMaxWidth && w == themeMaxWidth && !$imgMaxW.is(':checked')) {
                valueToSelect = '__full';
            }
        }

        /* if not yet chosen */
        if (!valueToSelect) {
            valueToSelect = '__custom';
        }

        /* apply the selected value */
        $imgSize.val(valueToSelect);
    }

    /**
     * gets the current WordPress theme max-width, as set by its CSS stylesheets
     * @param $tinyMCEBody the reference to the jQuery body element tag inside the TinyMCE iframe
     * @returns {number|undefined} the maximum width recommended by the theme, or undefined if not defined
     */
    var getThemeMaxWidth = function($tinyMCEBody) {
        var tempImgMaxWidthTest = $('<img />').appendTo($tinyMCEBody);
        var tempMaxWidth = tempImgMaxWidthTest.css('max-width');
        tempImgMaxWidthTest.remove();
        tempImgMaxWidthTest = null;

        if ('string' === typeof tempMaxWidth) {
            /* if it is given as pixels (eg. 474px), return it */
            if (tempMaxWidth.indexOf('px') > -1) {
                tempMaxWidth = parseInt(tempMaxWidth, 10);
                if (!isNaN(tempMaxWidth)) {
                    return tempMaxWidth;
                }
            } else if (tempMaxWidth.indexOf('%') > -1) {    /* if it is given as percent */
                /* look for a pixel value on its parent body */
                tempMaxWidth = $tinyMCEBody.css('max-width');
                /* if it is defined in pixels, return it */
                if ('string' === typeof tempMaxWidth && tempMaxWidth.indexOf('px') > -1) {
                    tempMaxWidth = parseInt(tempMaxWidth, 10);
                    if (!isNaN(tempMaxWidth)) {
                        return tempMaxWidth;
                    }
                }
            }
        }
    };

    var getPresetSizeFor = function(presetId) {
        var fullWidth = $clickedImage[0].naturalWidth;
        var fullHeight = $clickedImage[0].naturalHeight;
        var proportion = fullWidth / fullHeight;

        if ('__full' === presetId) {
            return {
                width: fullWidth,
                height: fullHeight
            };
        } else if ('__custom' === presetId) {
            return {
                width: parseInt($clickedImage.attr('width'), 10),
                height: parseInt($clickedImage.attr('height'), 10)
            };
        } else {
            var $opt = $imgSize.find('option[value="' + presetId + '"]');
            return {
                width: parseInt($opt.attr('data-preset-width'), 10),
                height: Math.round(parseInt($opt.attr('data-preset-width'), 10) / proportion)
            }
        }
    };

    var setImageSize = function(newWidth, newHeight) {
        /* set image dimensions */
        $clickedImage.attr('width', newWidth).attr('data-mce-width', newWidth).attr('_mce_width', newWidth);
        $clickedImage.attr('height', newHeight).attr('data-mce-height', newHeight).attr('_mce_height', newHeight);

        /* clear old inline styles, as they interfere with responsiveness */
        $clickedImage.css('width', '');
        $clickedImage.css('height', '');

        /* update the resizing rectangle to match the new image dimension */
        if (window.tinymce.isWebKit) {
            impro.updateResizeRect();
        }
    };

    /**
     * This function is triggered when any UI event that changes
     * a property of the image occurs from the Image Editor panel
     * in the right, and inside this function, action is taken
     * depending of the input field that changed. At the end, the
     * selected image in the post editor is updated with the new
     * settings
     */
    var updateImageSettings = function() {
        /* get the current width and height of the image */
        var newWidth = parseInt($clickedImage.attr('width'), 10);
        var newHeight = parseInt($clickedImage.attr('height'), 10);
        /* get the full width and height (the original size) of the image */
        var fullWidth = $clickedImage[0].naturalWidth;
        var fullHeight = $clickedImage[0].naturalHeight;
        /* the max-width value of the image */
        var maxWidth;
        /* compute the proportion between the width and the height of the image */
        var proportion = fullWidth / fullHeight;

        /* if we are changing the size preset */
        if (this.is($imgSize)) {
            /* get the preset size object */
            var presetSize = getPresetSizeFor($imgSize.val());
            newWidth = presetSize.width;
            newHeight = presetSize.height;

            /* if the responsiveness checkbox is checked */
            if ($imgMaxW.is(':checked')) {
                maxWidth = 'none';
            } else {
                maxWidth = '';
                /* resize to max-width */
                if ('number' === typeof themeMaxWidth && newWidth > themeMaxWidth) {
                    newWidth = themeMaxWidth;
                    newHeight = parseInt(newWidth / proportion, 10);
                }
            }
        }

        /* if we are toggling the responsiveness checkbox */
        if (this.is($imgMaxW)) {
            if ($imgMaxW.is(':checked')) {
                maxWidth = 'none';
                /* get the width from the manual size input */
                /* if it is full size or other size (except custom), take it from the dropdown */
                if ('__custom' !== $imgSize.val()) {
                    /* get the preset size object */
                    var presetSize = getPresetSizeFor($imgSize.val());
                    newWidth = presetSize.width;
                    newHeight = presetSize.height;
                } else {
                    newWidth = $imgW.val();
                    newHeight = parseInt(newWidth / proportion, 10);
                }
            } else {
                maxWidth = '';
                /* resize to max-width */
                if ('number' === typeof themeMaxWidth && newWidth > themeMaxWidth) {
                    newWidth = themeMaxWidth;
                    newHeight = parseInt(newWidth / proportion, 10);
                }
            }
        }

        /* if we are changing the size manually */
        if (this.is($imgW) || this.is($imgH)) {
            if (this.is($imgW)) {
                newWidth = parseInt(this.val(), 10);
                if (!isNaN(newWidth)) {
                    newHeight = parseInt(newWidth / proportion);
                }
            } else if (this.is($imgH)) {
                newHeight = parseInt(this.val(), 10);
                if (!isNaN(newHeight)) {
                    newWidth = parseInt(newHeight * proportion);
                }
            }

            /* any action on the custom fields should change the size dropdown to custom */
            if ('__custom' !== $imgSize.val()) {
                $imgSize.val('__custom');
            }
        }

        /* set image dimensions */
        if (newWidth && newHeight) {

            /* if it is too small, just add an error class */
            if (newWidth < MIN_W || newHeight < MIN_H) {
                $imgW.add($imgH).addClass('impro-editor-wh-error');
                return;
            } else if ('number' === typeof themeMaxWidth && themeMaxWidth < newWidth && !$imgMaxW.is(':checked')) {
                $imgW.add($imgH).addClass('impro-editor-wh-error');
                return;
            } else {
                $imgW.add($imgH).removeClass('impro-editor-wh-error');
            }

            /* change image size */
            setImageSize(newWidth, newHeight);

            /* update the width/height inputs */
            $imgW.val(newWidth);
            $imgH.val(newHeight);
        }
        /* set the max-width */
        if ('none' === maxWidth || '' === maxWidth) {
            $clickedImage.css('max-width', maxWidth);
            /* also remove it from data-mce-style, as it transmits it further and we do not need it */
            if ('' === maxWidth) {
                var dataMCEStyle = $clickedImage.attr('data-mce-style');
                if ('string' === typeof dataMCEStyle) {
                    dataMCEStyle = dataMCEStyle.replace(/max-width\s*:\s*none\s*;?/g, '');
                    $clickedImage.attr('data-mce-style', dataMCEStyle);
                }
            }
        }
    };

    var initEvents = function() {

        $imgSize.bind('change', function(ev) {
            updateImageSettings.call($(this));
        });

        $imgMaxW.bind('change', function(ev) {
            updateImageSettings.call($(this));
        });

        $imgW.add($imgH).bind('keyup change', function(ev) {
            updateImageSettings.call($(this));
            ev.stopImmediatePropagation(); /* keyup and change are bound. we only need one to get it */
        });

        /* there is no consistent and 100% correct way to be notified on the image's resize. that's why we use polling */
        var tInterval = 0;
        tInterval = setInterval(function() {
            if ($clickedImage && $clickedImage.length) {
                /* do not refresh manual size inputs while user is making changes (is in focus there) */
                if ($imgW.is(':focus') || $imgH.is(':focus')) {
                    return;
                }

                /* if the image is not attached any more to the body */
                if ($clickedImage.closest('body').length === 0) {
                    closeEditor();
                }

                /* get previous size data */
                var prevW = $clickedImage.data('prevW');
                var prevH = $clickedImage.data('prevH');
                var currentW = $clickedImage.width();
                var currentH = $clickedImage.height();

                /* DeMorgan Law. if no size previously or different sizes, update UI and image data size cache */
                if (((prevW !== undefined && prevH !== undefined) && (prevW !== currentW || prevH !== currentH)) || (!(prevW !== undefined && prevH !== undefined))) {
                    /* >0 is used to not intercept the images that are just being added, until they get loaded */
                    /* prevent resizing to very small images - disabled for the moment because of a bug
                    if ((currentW < MIN_W || currentH < MIN_H) && (currentW > 0 || currentH > 0)) {
                        var fullWidth = $clickedImage[0].naturalWidth;
                        var fullHeight = $clickedImage[0].naturalHeight;
                        var proportion = fullWidth / fullHeight;

                        if (currentW < currentH) {
                            currentW = MIN_W + 20;
                            currentH = currentW / proportion;
                        } else {
                            currentH = MIN_H + 20;
                            currentW = currentH * proportion;
                        }

                        setImageSize(currentW, currentH);

                        alert('You cannot resize an image to a size smaller than ' + MIN_W + 'x' + MIN_H + ' pixels!');
                    }
                    //*/

                    /* round values */
                    currentW = Math.round(currentW);
                    currentH = Math.round(currentH);

                    /* set custom sizes */
                    $imgW.val(currentW);
                    $imgH.val(currentH);
                    $clickedImage.data('prevW', currentW);
                    $clickedImage.data('prevH', currentH);

                    /* set the size preset */
                    selectCorrectPreset(currentW, currentH);
                }
            }
        }, 200);




        var changeProps = function(ev) {
            /* preview */
            $clickedImage.attr('alt', $('.impro_alt').val());
            $clickedImage.attr('title', $('.impro_title').val());
            $clickedImage.removeClass('alignnone alignleft aligncenter alignright').addClass($('.impro_align').val());

            /* save */
            $clickedImage.attr('_mce_alt', $('.impro_alt').val());
            $clickedImage.attr('_mce_title', $('.impro_title').val());
            $clickedImage.attr('_mce_class', $clickedImage.attr('class'));

            ev.stopImmediatePropagation();
        };

        $('.impro_align, .impro_alt, .impro_title').bind('change keyup', changeProps);

        $('.impro_link').click(function() {
            if ($(this).is(':checked')) {
                tinyMCE.activeEditor.execCommand('mceInsertLink', false, { href: $clickedImage.attr('src'), target: '_blank' });
            } else {
                tinyMCE.activeEditor.execCommand('mceInsertLink', false, '');
            }
        });
    };

    var onSwitchEditor = function(id, mode) {

    };

    /* public methods */
    $.extend(this, {
        init: init,
        getTinyMCE: getTinyMCE
    });
}).call(impro.editor = {}, jQuery);

jQuery(function() {
	impro.editor.init();
});