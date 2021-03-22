/**
 * Author: Karan Singh Singare
 */

(function($) {

  /**
   * Testing the ajax call
   */
  // adding a trigger
  // $(document).ready(() => {
  //   $('.tutors-container .tutor_select_submit').on('click', (event) => {
  //     sendAjaxRequest();
  //   });
  // })
  // console.log($('.tutors-container'));


  // $(document).read(() => {
  //   // $.ajax({
  //   //   type: 'GET',
  //   //   url: '/modules/custom/karan_ajax/ajax/tutor_search.php',
  //   //   success: function(feedback) {
  //   //     console.log(feedback);
  //   //   }
  //   // });
  // });
  $(document).ready(() => {
    const user_id = parseInt($('#hidden_user_id')[0].value);
    console.log(user_id);

    $.ajax({
        type: 'GET',
        url: `/user/${user_id}?_format=json`,
        success: function(feedback) {
          console.log(feedback);
        }
    });
    $.ajax({
        type: 'GET',
        url: `/api/users`,
        success: function(feedback) {
          console.log(feedback);
        }
    });

  })


})(jQuery);

function sendAjaxRequest() {
  $.ajax({
    type: 'POST',
    url: '/modules/custom/karan_ajax/ajax/tutor_search.php',
    success: function(feedback) {
      console.log(feedback);
    }
  });
}
