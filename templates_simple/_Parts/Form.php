{% autoescape true %}
<h3>投稿フォーム</h3>
<form method="post" action="/post/commit">
    <input type="hidden" name="{{csrf_key}}" value="{{csrf_token}}">

    <div>
        ニックネーム<em>(半角英数16文字まで)</em><br>
        <input type="text" name="nickname" value="{{ params.nickname }}"><br>
        <span style="color:red">{{error_list.nickname}}</span>
    </div>

    <div>
        テキスト<em>(1000文字まで)</em><br>
        <textarea name="body">{{params.body}}</textarea><br>
        <span style="color:red">{{error_list.body}}</span>
    </div>

    <input type="submit" class="btn btn-primary btn-block" value="投稿する">
</form>
{% endautoescape %}
