/**/
$(document).ready(function(){
  $('input').iCheck({
    checkboxClass: 'icheckbox_square-purple',
    radioClass: 'iradio_square-purple',
    increaseArea: '20%' // optional
  });
  $('table#listing.tablesorter').tablesorter({textExtraction:function(s) {
    if ($(s).find('img').length == 0) return $(s).text();
    return $(s).find('img').attr('alt');
  }});
});
/**/
/**
$(document).ready(function(){
  $('input').each(function(){
    var self = $(this),
      label = self.next(),
      label_text = label.text();

    label.remove();
    self.iCheck({
      checkboxClass: 'icheckbox_line-purple',
      radioClass: 'iradio_line-purple',
      insert: '<div class="icheck_line-icon"></div>' + label_text
    });
  });
});
/**/
