# coffeescript
$ ->
    # TODO: それぞれのフォームでのチェック

    # init variables
    td_boxs            = $('table.table-words td').not('.emp')
    ans_form               = $('#answer-form')
    process_count_span = $('span#process_count')
    btn_end            = $('#submit-end')
    btn_start          = $('#submit-start')
    btn_tweet          = $('#submit-tweet')
    btn_answer         = $('#submit-answer')
    time_box           = $('#time-box')
    word_boxs          = $('.wordbox')
    all_word_num       = td_boxs.size()
    game_id            = $('#game-id').val()
    game_name          = $('#game-name').val()
    word_unit          = $('#word-unit').val()
    solve_count        = 0
    game_flag          = 0
    dtime              = 0
    start_time         = null
    timer_id           = null
    data_start_id      = []
    stc = $.SuperTextConverter()
    btn_end.hide()
    btn_answer.hide()
    btn_tweet.hide()
    input_game_name = $('#input_game_name')

    to_ans_kana = (str) ->
        return stc.toHankaku(stc.toHiragana(stc.killHankakuKatakana(str)),
            convert:
                punctuation: false
        ).toLowerCase()

    replay = () ->
        word = ans_form.val()
        if game_flag != 1 || !word
            return
        # 全角ひらがな半角英数字に統一する
        word_k = to_ans_kana(word)
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
        # 人気アイテムの統計
        data_start_id.push td.attr 'nid'
        solve_count++
        process_count_span.html(solve_count)
        console.log solve_count
        console.log all_word_num
        if solve_count == all_word_num
            game_end()

    game_end = ->
        game_flag = 0
        clearInterval(timer_id)
        btn_end.hide()
        btn_answer.hide()
        btn_start.show()
        btn_tweet.show()
        ng_ids = []
        td_boxs.not('.ok').each ->
            $(@).html($(@).attr('ans'))
            $(@).addClass('ng')
            ng_ids.push $(@).attr 'nid'
        if all_word_num < 5 || data_start_id.length >= 1
            post_result(data_start_id, ng_ids)

    game_start = ->
        game_flag = 2
        start_time = new Date().getTime()
        btn_start.hide()
        btn_tweet.hide()
        btn_answer.show()
        btn_end.show()
        dtime = 0
        solve_count = 0
        data_start_id = []
        btn_answer.attr('disabled', '')
        btn_end.attr('disabled', '')
        process_count_span.html(0)
        time_box.css('color', 'red')
        td_boxs.each ->
            $(@).html("")
            $(@).removeClass('ok')
            $(@).removeClass('ng')
        timer_id = setInterval ->
            my_disp_down()
        ,1

    game_start_open = ->
        game_flag = 1
        btn_answer.removeAttr('disabled')
        btn_end.removeAttr('disabled')
        clearInterval(timer_id)
        start_time = new Date().getTime()
        time_box.css('color', 'black')
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

    my_disp_down = ->
        dtime = 3000 - (new Date().getTime() - start_time)
        if dtime <= 0
            game_start_open()
            return
        myS = Math.floor(dtime/1000) +  1
        time_box.html("--:--:" + to_double0(myS) + ".--")

    btn_start.click ->
        ans_form.focus()
        game_start()

    btn_end.click ->
        game_end()

    post_result = (start_ids, ng_ids)->
        start_ids = start_ids.filter (e)->
            return !!e
        ng_ids = ng_ids.filter (e)->
            return !!e
        console.log start_ids
        console.log ng_ids
        data =
            start_ids: start_ids.join ","
            ng_ids: ng_ids.join ","
        $.ajax(
            type: "POST",
            url: "../game/result/" + game_id
            data: data,
            success: (res) ->
                console.log res
            error: ->
                console.log 'result post error'
        )

    ans_form.on("keypress", (e) ->
        if e.which == 13
            replay()
    )
    btn_answer.click ->
        replay()
        ans_form.focus()

    add_list = ->
#        include_list()
        add_text = $('#input_add').val()
        add_words = add_text.split(/[,\s]/).filter (e)->
            return !!e
        $.each(add_words, (i, v) ->
            add_words[i] = v.substr(0, 20)
        )

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
        game_name = $.trim(input_game_name.val())
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
        # 半角スペース3桁埋め
        $('#num').html(('   ' + c).substr(-3).replace(' ', '&nbsp;'))

    word_boxs.change ->
        wordbox_change()

    wordbox_clear = ->
        word_boxs.each ->
            $(@).val("")


    $('#submit-clear').click wordbox_clear

    name_check = ->
        data =
            name: input_game_name.val()
        $('#check-name').html('check')
        $('#check-name').parent().parent().removeClass('has-error')
        $.ajax(
            type: "POST",
            url: "make/check",
            data: data,
            success: (res) ->
                if res == "s"
                    $('#check-name').html('使うことのできるタイトルです')
                    $('#check-name').css('color', 'green')
                else
                    $('#check-name').html('既に使われているタイトルです')
                    $('#check-name').parent().parent().addClass('has-error')
                    $('#check-name').css('color', 'red')
            error: ->
                console.log 'check error'
        )
    input_game_name.change -> name_check()

    $('#check-btn').click ->
        ok = true
        if gn = $.trim input_game_name.val()
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
            success: (res) ->
                console.log res
                ress = res.split(':')
                res_code = ress[0]
                res_text = ress[1]
                switch res_code
                    when 'e'
                        console.log "ゲーム名が既に使われています"
                    when 's'
                        location.href = 'g/' + res_text
            error: ->
                console.log 'connect error'
        )
    $('.wordbox').change -> wordbox_change

    btn_tweet.click ->
        hashtags = '言えるかな'
        time = to_time_str(time_box.html())
        text = "#{game_name}を#{all_word_num}#{word_unit}中#{solve_count}#{word_unit}言えました[#{time}]"
        share_url = location.href
        url = "https://twitter.com/intent/tweet?hashtags=#{hashtags}&text=#{text}&url=#{share_url}"
        window.open(url)
    
    to_time_str = (time) ->
        ts = time.split(':')
        time_h = ts[0] * 1
        time_m = ts[1] * 1
        ts2 = ts[2].split('.')
        time_s = ts2[0] * 1
        return (if time_h then time_h + '時間' else '') + "" + (if time_m then time_m + '分' else '') + "" + time_s + '秒'

