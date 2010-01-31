$('document').ready(function(){
    function disable(el) {
        $('textarea, input, select', el).attr('disabled', true);
    }
    function enable(el) {
        $('textarea, input, select', el).attr('disabled', false);
    }
    $('.recruit-tweets').bind('submit', function(){
        var tweet = $('textarea', this).val();
        var url = $('.endpoint', this).attr('value');
        disable(this);
        var that = this;
        $.get(url + '/' + encodeURI(tweet),
              {},
              function() {
                enable(that);
              });
        return false;
    });
    $('#repair-avatar-btn').click(function(){
        $(this).attr('disabled', 'disabled');
        var that = this;
        $.get('/oauth/repairAvatar', function(){
            $(that).attr('disabled', null);
        });
    });
});