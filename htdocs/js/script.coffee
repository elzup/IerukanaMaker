# coffeescript
$ ->
    # TODO: それぞれのフォームでのチェック

    # init variables
    all_word_num = $('table.words-table td').size()
    form = $('#answer-form')
    process_count_span = $('span#process_count')
    solve_count = 0
    game_flag = 0
    btn_end = $('#submit-end')

    replay = () ->
        if game_flag != 1
            return
        word = form.val()
        td = $("td[ans=#{word}]")
        if !td
            return
        td.removeAttr('ans')
        td.html(word)
        form.val('')
        solve_count++
        process_count_span.html(solve_count)
        if solve_count == all_word_num
            game_end()

    game_end = ->
        game_flag = 0
    game_start = ->
        game_flag = 1
        alert 'start!'

    $('#submit-start').click ->
        $(@).hide()
        btn_end.show()

    btn_end.click ->
        game_start()

    form.on("keypress", (e) ->
        if e.which == 13
            replay()
    )
    $('#submit-answer').click -> replay()

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
        wordbox_change()

    $('#submit-add').click add_list
    $('#input_add').on("keypress", (e) ->
        if e.which == 13
            add_list()
    )

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
    wordbox_change = ->
        console.log 'changed'

    wordbox_clear = ->
        $(".wordbox").each ->
            $(@).val("")


    $('#submit-clear').click wordbox_clear

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
                if data == 'e1'
                    console.log "ゲーム名が既に使われています"
                else
                    location.href = 'g/' + data
            error: ->
                console.log 'connect error'
        )
    $('.wordbox').change -> wordbox_change


