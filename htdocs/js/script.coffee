# coffeescript
$ ->
    # TODO: それぞれのフォームでのチェック

    # init variables
    td_boxs            = $('table.table-words td')
    ans_form               = $('#answer-form')
    process_count_span = $('span#process_count')
    btn_end            = $('#submit-end')
    btn_start          = $('#submit-start')
    time_box           = $('#time-box')
    word_boxs          = $('.wordbox')
    all_word_num       = td_boxs.size()
    game_id            = $('#game-id').val()
    solve_count        = 0
    game_flag          = 0
    dtime              = 0
    start_time         = null
    timer_id           = null
    data_start_id      = []
    stc = $.SuperTextConverter()

    btn_end.hide()

    to_ans_kana = (str) ->
        return stc.toHankaku(stc.toHiragana(stc.killHankakuKatakana(str)),
            convert:
                punctuation: false
        )

    replay = () ->
        word = ans_form.val()
        if game_flag != 1 || !word
            return
        # 全角ひらがな半角英数字に統一する
        word_k = to_ans_kana(word)
#        console.log word
        console.log word_k
        td = $("td[ansc=#{word_k}]")
        ans = td.attr 'ans'
#        console.log td
#        console.log ans
        if td.size() < 1 || td.hasClass "ok"
            return
        # 正解した場合
        td.html(ans)
        td.addClass('ok')
        ans_form.val('')
        # 人気アイエムの統計
        data_start_id.push td.attr 'nid'
        solve_count++
        process_count_span.html(solve_count)
        if solve_count == all_word_num
            game_end()

    game_end = ->
        game_flag = 0
        clearInterval(timer_id)
        btn_start.show()
        btn_end.hide()
        ng_ids = []
        td_boxs.not('.ok').each ->
            $(@).html($(@).attr('ans'))
            $(@).addClass('ng')
            ng_ids.push $(@).attr 'nid'
        if data_start_id.length >= 1
            post_result(data_start_id, ng_ids)

    game_start = ->
        game_flag = 1
        start_time = new Date().getTime()
        btn_start.hide()
        btn_end.show()
        dtime = 0
        solve_count = 0
        data_start_id = []
        process_count_span.html(0)
        td_boxs.each ->
            $(@).html("")
            $(@).removeClass('ok')
            $(@).removeClass('ng')
        timer_id = setInterval ->
            my_disp()
        ,1

    to_double0 = (n)->
        if n < 10
            return '0' + n
        return n

    my_disp = ->
        dtime = new Date().getTime() - start_time
        myH = Math.floor(dtime/(60*60*1000))
        dtime = dtime-(myH*60*60*1000)
        myM = Math.floor(dtime/(60*1000))
        dtime = dtime-(myM*60*1000)
        myS = Math.floor(dtime/1000)
        myMS = Math.floor(dtime / 10 % 100)
        time_box.html(to_double0(myH) + ":" + to_double0(myM) + ":" + to_double0(myS) + "." + to_double0(myMS))

    btn_start.click ->
        ans_form.focus()
        game_start()

    btn_end.click ->
        game_end()

    post_result = (start_ids, ng_ids)->
        data =
            start_ids: start_ids.join ","
            ng_ids: ng_ids.join ","
        $.ajax(
            type: "POST",
            url: "../game/result/" + game_id
            data: data,
            success: (res) ->
                console.log res
                console.log 'result posted'
            error: ->
                console.log 'result post error'
        )

    ans_form.on("keypress", (e) ->
        if e.which == 13
            replay()
    )
    $('#submit-answer').click ->
        replay()
        ans_form.focus()

    add_list = ->
#        include_list()
        add_text = $('#input_add').val()
        add_words = add_text.split(/[,\s]/).filter (e)->
            return !!e
        add_words = $.unique(add_words)
        word_boxs.each ->
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
        word_boxs.each ->
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
        c = 0
        word_boxs.each ->
            c++ if $(@).val() != ""
        $('#num').html(c)

    word_boxs.change ->
        wordbox_change()

    wordbox_clear = ->
        word_boxs.each ->
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


