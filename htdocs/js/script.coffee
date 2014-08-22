# coffeescript
$ ->
    # TODO: それぞれのフォームでのチェック

#    include_list = ->
#        for j in [16...32]
#            rowDiv = $("<div/>").addClass("row row-word")
#            for i in [0...8]
#                rowDiv.append($("<div/>").addClass("wordbox").attr
#                    id: "input_word_" + j * 8 + i
#                    name: "word-" + j * 8 + i
#                    maxlength: 10
#                    value: ""
#                    placeholder: "---"
#                    type: "text"
#                )
#            console.log rowDiv
#            $("#word-list-box").append(rowDiv)
    # TODO: enter時も
    add_list = ->
#        include_list()
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

    # 合計numの更新
    wordbox_change = -
        console.log 'changed'
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
    $('.wordbox').change -> wordbox_change


