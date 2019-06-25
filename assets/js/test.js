$(function() {

    var mark = function() {
  
      // Read the keyword
      var keyword = $("input[name='q']").val();
  
      // Determine selected options
      var options = {};
      $("input[name='opt[]']").each(function() {
        options[$(this).val()] = $(this).is(":checked");
      });

      // Remove previous marked elements and mark
      // the new keyword inside the context
      $(".cmdbResult").unmark({
        done: function() {
          $(".cmdbResult").mark(keyword, options);
        }
      });
    };
  
    $("input[name='q']").on("input", mark);
  
  });
  