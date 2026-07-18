/* ===========================================================
 * trumbowyg.imagemanager.js
 * Custom Insert Image dialog for the Bodare MPC admin panel.
 *
 * Replaces Trumbowyg's built-in insertImage command with a
 * dialog that supports:
 *   - direct image upload (saved to the server Image Manager)
 *   - an Image Manager popup listing previously uploaded images
 *   - manual URL entry, like the original dialog
 *   - double-click on an existing image to edit it with the same UI
 * ===========================================================
 */

(function ($) {
    'use strict';

    var defaultOptions = {
        uploadPath: '',
        browsePath: ''
    };

    function escapeHtml(value) {
        return String(value == null ? '' : value).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function formatSize(bytes) {
        bytes = parseInt(bytes, 10) || 0;
        if (bytes >= 1048576) {
            return (bytes / 1048576).toFixed(1) + ' MB';
        }
        if (bytes >= 1024) {
            return Math.round(bytes / 1024) + ' KB';
        }
        return bytes + ' B';
    }

    function closeManagerPopup() {
        $('.tbw-im-overlay').remove();
    }

    /* Image Manager popup: grid of previously uploaded images. */
    function openManagerPopup(options, onSelect) {
        closeManagerPopup();

        var $overlay = $('<div class="tbw-im-overlay"></div>').css({
            position: 'fixed',
            top: 0, left: 0, right: 0, bottom: 0,
            background: 'rgba(0,0,0,.45)',
            zIndex: 100000,
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center'
        });

        var $panel = $('<div></div>').css({
            background: '#fff',
            width: '560px',
            maxWidth: '92%',
            maxHeight: '72vh',
            borderRadius: '6px',
            boxShadow: '0 10px 40px rgba(0,0,0,.35)',
            display: 'flex',
            flexDirection: 'column',
            overflow: 'hidden'
        });

        var $header = $(
            '<div style="display:flex;align-items:center;justify-content:space-between;' +
            'padding:12px 16px;border-bottom:1px solid #e5e5e5;">' +
            '<strong style="font-size:15px;">Image Manager</strong>' +
            '<button type="button" class="tbw-im-close" style="border:0;background:none;' +
            'font-size:20px;line-height:1;cursor:pointer;color:#666;">&times;</button>' +
            '</div>'
        );

        var $body = $('<div></div>').css({
            overflowY: 'auto',
            padding: '10px 16px'
        }).html('<p style="color:#888;margin:10px 0;">Loading images...</p>');

        $panel.append($header, $body);
        $overlay.append($panel).appendTo('body');

        $header.find('.tbw-im-close').on('click', closeManagerPopup);
        $overlay.on('click', function (e) {
            if (e.target === this) {
                closeManagerPopup();
            }
        });

        $.getJSON(options.browsePath)
            .done(function (response) {
                var files = (response && response.files) || [];
                if (!files.length) {
                    $body.html('<p style="color:#888;margin:10px 0;">No images uploaded yet. ' +
                        'Use the Upload button in the Insert Image dialog to add one.</p>');
                    return;
                }

                $body.empty();
                $.each(files, function (i, file) {
                    var $row = $(
                        '<div style="display:flex;align-items:center;gap:12px;' +
                        'padding:8px;border:1px solid #e5e5e5;border-radius:4px;margin-bottom:8px;">' +
                        '<img src="' + escapeHtml(file.url) + '" alt="" style="width:72px;height:52px;' +
                        'object-fit:cover;border-radius:3px;flex-shrink:0;background:#f4f4f4;">' +
                        '<div style="flex:1;min-width:0;">' +
                        '<div style="font-size:13px;word-break:break-all;">' + escapeHtml(file.path) + '</div>' +
                        '<div style="font-size:11px;color:#999;">' + formatSize(file.size) + '</div>' +
                        '</div>' +
                        '<button type="button" class="tbw-im-select" style="flex-shrink:0;border:1px solid #4caf50;' +
                        'background:#4caf50;color:#fff;border-radius:3px;padding:5px 14px;cursor:pointer;">Select</button>' +
                        '</div>'
                    );
                    $row.find('.tbw-im-select').on('click', function () {
                        onSelect(file.url);
                        closeManagerPopup();
                    });
                    $body.append($row);
                });
            })
            .fail(function () {
                $body.html('<p style="color:#f44336;margin:10px 0;">Could not load the image list. Please try again.</p>');
            });
    }

    function getImageDimension($img, attr) {
        if (!$img || !$img.length) {
            return '';
        }

        var value = $img.attr(attr);
        if (value) {
            return String(value).replace(/px$/i, '');
        }

        var styleValue = $img[0].style && $img[0].style[attr];
        if (styleValue) {
            return String(styleValue).replace(/px$/i, '');
        }

        return '';
    }

    function applyImageSize($img, width, height) {
        width = $.trim(String(width || ''));
        height = $.trim(String(height || ''));

        if (width !== '') {
            $img.attr('width', width);
            $img.css('width', /^\d+$/.test(width) ? width + 'px' : width);
        } else {
            $img.removeAttr('width');
            $img.css('width', '');
        }

        if (height !== '') {
            $img.attr('height', height);
            $img.css('height', /^\d+$/.test(height) ? height + 'px' : height);
        } else {
            $img.removeAttr('height');
            $img.css('height', '');
        }
    }

    /**
     * Open the custom Insert Image dialog.
     * @param {object} trumbowyg
     * @param {object} options
     * @param {jQuery|null} $editImage existing image to update on confirm, or null to insert
     */
    function openInsertImageDialog(trumbowyg, options, $editImage) {
        trumbowyg.saveRange();

        var prefix = trumbowyg.o.prefix;
        var isEditing = !!($editImage && $editImage.length);
        var currentSrc = isEditing ? ($editImage.attr('src') || '') : '';
        var currentAlt = isEditing ? ($editImage.attr('alt') || '') : trumbowyg.getRangeText();
        var currentWidth = isEditing ? getImageDimension($editImage, 'width') : '';
        var currentHeight = isEditing ? getImageDimension($editImage, 'height') : '';
        var dialogTitle = isEditing ? 'Update Image' : 'Insert Image';

        if (currentSrc.indexOf('data:image') === 0) {
            currentSrc = '(Base64)';
        }

        var html =
            '<div class="tbw-im-upload-row" style="display:flex;align-items:center;gap:8px;padding:8px 15px 2px;">' +
            '<span style="white-space:nowrap;font-weight:bold;font-size:13px;">Upload Image:</span>' +
            '<input type="file" name="tbwImFile" accept="image/*" style="flex:1;min-width:0;font-size:12px;">' +
            '<button type="button" class="tbw-im-upload-btn" style="border:1px solid #4caf50;background:#fff;' +
            'color:#4caf50;border-radius:3px;padding:5px 14px;cursor:pointer;font-weight:bold;">Upload</button>' +
            '</div>' +
            '<div class="tbw-im-status" style="padding:0 15px 2px;font-size:12px;min-height:16px;color:#999;"></div>' +
            '<label><input type="text" name="url" value="' + escapeHtml(currentSrc) + '">' +
            '<span class="' + prefix + 'input-infos"><span>URL</span></span></label>' +
            '<label><input type="text" name="alt" value="' + escapeHtml(currentAlt) + '">' +
            '<span class="' + prefix + 'input-infos"><span>Description</span></span></label>' +
            '<div class="tbw-im-size-row" style="display:flex;align-items:center;gap:8px;padding:6px 15px 2px;">' +
            '<span style="white-space:nowrap;font-weight:bold;font-size:13px;">Width:</span>' +
            '<input type="number" name="imgwidth" min="1" placeholder="auto" value="' + escapeHtml(currentWidth) + '"' +
            ' style="width:90px;height:28px;border:1px solid #DEDEDE;padding:0 7px;font-size:14px;">' +
            '<span style="font-size:12px;color:#999;">px</span>' +
            '<span style="white-space:nowrap;font-weight:bold;font-size:13px;margin-left:10px;">Height:</span>' +
            '<input type="number" name="imgheight" min="1" placeholder="auto" value="' + escapeHtml(currentHeight) + '"' +
            ' style="width:90px;height:28px;border:1px solid #DEDEDE;padding:0 7px;font-size:14px;">' +
            '<span style="font-size:12px;color:#999;">px</span>' +
            '</div>' +
            '<div style="padding:0 15px 4px;font-size:11px;color:#999;text-align:left;">Leave width/height blank to keep the original size.</div>' +
            '<div class="tbw-im-manager-row" style="padding:4px 15px 8px;text-align:left;">' +
            '<button type="button" class="tbw-im-manager-btn" style="border:1px solid #d32f2f;background:#fff;' +
            'color:#d32f2f;border-radius:3px;padding:6px 16px;cursor:pointer;font-weight:bold;">Image Manager</button>' +
            '<span style="font-size:11px;color:#999;margin-left:8px;">Pick an image you uploaded before.</span>' +
            '</div>';

        var $modal = trumbowyg.openModal(dialogTitle, html);
        if ($modal === false) {
            return false;
        }

        var $modalBox = $('.' + prefix + 'modal-box', $modal);
        var previousBoxOverflow = trumbowyg.$box.css('overflow');

        // Custom form is taller than the default Insert Image dialog.
        // Pin it to the viewport so Confirm/Cancel are never clipped by the editor.
        function fitInsertImageModal() {
            var neededHeight = $modalBox.outerHeight() + 10;
            var topOffset = Math.max(20, Math.round((window.innerHeight - neededHeight) / 2));

            $modal.css({
                position: 'fixed',
                top: topOffset + 'px',
                left: '50%',
                transform: 'translateX(-50%)',
                width: '520px',
                maxWidth: '94vw',
                height: neededHeight,
                maxHeight: 'none',
                overflow: 'visible',
                zIndex: 10050
            });
            $modalBox.css({
                overflow: 'visible',
                zIndex: 10051
            });
            trumbowyg.$box.css({
                overflow: 'visible',
                zIndex: 'auto'
            });

            if (trumbowyg.$overlay && trumbowyg.$overlay.length) {
                trumbowyg.$overlay.css({
                    position: 'fixed',
                    top: 0,
                    left: 0,
                    right: 0,
                    bottom: 0,
                    width: '100%',
                    height: '100%',
                    zIndex: 10040
                });
            }
        }

        function restoreInsertImageModal() {
            trumbowyg.$box.css({
                overflow: previousBoxOverflow || '',
                zIndex: ''
            });
            if (trumbowyg.$overlay && trumbowyg.$overlay.length) {
                trumbowyg.$overlay.css({
                    position: '',
                    top: '',
                    left: '',
                    right: '',
                    bottom: '',
                    width: '',
                    height: '',
                    zIndex: ''
                });
            }
        }

        fitInsertImageModal();
        setTimeout(fitInsertImageModal, 0);

        var $urlInput = $('input[name=url]', $modal);
        var $status = $('.tbw-im-status', $modal);

        /* 1-3. Upload the chosen file, then paste its URL below. */
        $('.tbw-im-upload-btn', $modal).on('click', function () {
            var fileInput = $('input[name=tbwImFile]', $modal)[0];
            if (!fileInput.files || !fileInput.files.length) {
                $status.css('color', '#f44336').text('Please choose an image file first.');
                return;
            }

            var data = new FormData();
            data.append('imagefile', fileInput.files[0]);
            $status.css('color', '#999').text('Uploading...');

            $.ajax({
                url: options.uploadPath,
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false
            }).done(function (response) {
                if (response && response.success) {
                    $urlInput.val(response.url).trigger('change');
                    $status.css('color', '#4caf50').text('Uploaded "' + response.name + '" - the URL was pasted below.');
                } else {
                    $status.css('color', '#f44336').text((response && response.error) || 'Upload failed.');
                }
            }).fail(function () {
                $status.css('color', '#f44336').text('Upload failed. Please try again.');
            });
        });

        /* 4. Open the Image Manager popup to reuse an uploaded image. */
        $('.tbw-im-manager-btn', $modal).on('click', function () {
            openManagerPopup(options, function (url) {
                $urlInput.val(url).trigger('change');
                $status.css('color', '#4caf50').text('Image URL copied from the Image Manager.');
            });
        });

        $modal.on('tbwconfirm', function () {
            var url = $.trim($urlInput.val());
            var alt = $.trim($('input[name=alt]', $modal).val());
            var width = $.trim($('input[name=imgwidth]', $modal).val());
            var height = $.trim($('input[name=imgheight]', $modal).val());

            if (url === '') {
                trumbowyg.addErrorOnModalField($urlInput, trumbowyg.lang.required || 'Required');
                return;
            }

            trumbowyg.restoreRange();

            if (isEditing) {
                if (url !== '(Base64)') {
                    $editImage.attr('src', url);
                }
                $editImage.attr('alt', alt);
                applyImageSize($editImage, width, height);
            } else {
                trumbowyg.execCmd('insertImage', url);
                var $inserted = $('img[src="' + url + '"]', trumbowyg.$box).last();
                if (alt !== '') {
                    $inserted.attr('alt', alt);
                }
                applyImageSize($inserted, width, height);
            }

            trumbowyg.syncCode();
            trumbowyg.$c.trigger('tbwchange');
            closeManagerPopup();
            restoreInsertImageModal();
            trumbowyg.closeModal();
            $modal.off('tbwconfirm');
        });

        $modal.one('tbwcancel', function () {
            $modal.off('tbwconfirm');
            closeManagerPopup();
            restoreInsertImageModal();
            trumbowyg.closeModal();
        });

        return false;
    }

    $.extend(true, $.trumbowyg, {
        plugins: {
            imagemanager: {
                init: function (trumbowyg) {
                    var options = trumbowyg.o.plugins.imagemanager =
                        $.extend(true, {}, defaultOptions, trumbowyg.o.plugins.imagemanager || {});

                    // Without server endpoints, keep the default insertImage dialog.
                    if (!options.uploadPath || !options.browsePath) {
                        return;
                    }

                    trumbowyg.addBtnDef('insertImage', {
                        fn: function () {
                            openInsertImageDialog(trumbowyg, options, null);
                        }
                    });

                    // Double-click an existing image to open the same custom dialog.
                    trumbowyg.o.imgDblClickHandler = function () {
                        return openInsertImageDialog(trumbowyg, options, $(this));
                    };
                }
            }
        }
    });
})(jQuery);
