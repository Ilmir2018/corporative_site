jQuery(document).ready(function () {

    $('.commentlist li').each(function (i) {

        $(this).find('div.commentNumber').text('#' + (i + 1))

    })

    $('#commentform').on('click', '#submit', function (e) {

        e.preventDefault();

        let comParent = $(this);

        $('.wrap_result').css('color', 'green').
        text('Сохранение комментария').fadeIn(500, function () {

            let data = $('#commentform').serializeArray();

            $.ajax({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#commentform').attr('action'),
                data: data,
                type: 'POST',
                datatype: 'JSON',
                success: function (html) {
                    if (html.error) {
                        $('.wrap_result').css('color', 'red').append('<br> <strong>Ошибка:</strong>' + html.error.join('<br>'));
                        $('.wrap_result').delay(2000).fadeOut(500);

                    } else if (html.success) {
                        /**
                         * Если в html нам приходит true из php выполняется данный код
                         * В формируемый блок wrap_result мы добавляем текст. Этот блок
                         * убирается через 2 сек, после чего после 0,5 сек вып ф-ция в fadeOut.
                         */
                        $('.wrap_result')
                            .append('<br><strong>Сохранено!</strong>')
                            .delay(2000).fadeOut(500, function () {
                                if (html.data.parent_id > 0) {
                                    comParent.parents('div#respond')
                                        .prev().after('<ul class="children">' + html.comment + '</ul>');
                                } else {
                                    if ($.contains('#comments', 'ol.commentlist')) {

                                        $('ol.commentlist').append(html.comment);

                                    } else {

                                        $('#respond').before('<ol class="commentlist group">' + html.comment + '</ol>')

                                    }
                                }

                                //Имитация клика по кнопке, чтобы срзу же отобразилось правильное место комментария
                                $('#cancel-comment-reply-link').click();
                        });
                    }
                },
                error: function () {

                    $('.wrap_result').css('color', 'red').append('<br> <strong>Ошибка!</strong>');
                    $('.wrap_result').delay(2000).fadeOut(500, function () {
                        $('#cancel-comment-reply-link').click();
                    });
                }

            })

        });

    })
});
