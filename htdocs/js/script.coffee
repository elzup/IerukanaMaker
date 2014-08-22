# coffeescript
$ ->
    # TODO: それぞれのフォームでのチェック
    # チェックボタン押下
    # TODO: enter時も
    add_list = ->
        add_text = $('#input_add').val()
        add_words = add_text.split(/[,\s]/).filter (e)->
            return !!e
        add_words = $.unique(add_words)
        $(".wordbox").each ->
            if !$(@).val()
                $(@).val(add_words.shift())
                if add_words.length == 0
                    return false
        $('#input_add').val("")

    $('#submit-add').click add_list

    # チェックボタン押下
    get_forms = ->
        wordlist = []
        $('.wordbox').each ->
            v = $.trim $(@).val()
            wordlist.push v if v
        words_text = wordlist.join(',')
        game_name = $.trim($('#input_game_name').val())
        words_unit = $.trim $('#input_words_unit').val()
        game_description = $.trim $('#input_description').val()
        if words_text != '' && game_name? && words_unit? && game_description
            return data =
                game_name: game_name
                words_unit: words_unit
                game_description: game_description
                words_list_text: words_text
        return false

    $('#check-btn').click ->
        ok = true
        if gn = $.trim $('#input_game_name').val()
            gn
        else
            ok = false
        $('#input_words_unit').val()
        $('#input_descripiton').val()
    # 送信ボタン押下
    $('#submit-btn').click ->
        if !(data = get_forms())
            console.log 'form no comp'
            return false
        $.ajax(
            type: "POST",
            url: "make/post",
            data: data,
            success: (data) ->
                console.log data
            error: ->
                console.log 'connect error'
        )

