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
    // console.log(user_id);
    //
    // $.ajax({
    //     type: 'GET',
    //     url: `/user/${user_id}?_format=json`,
    //     success: function(feedback) {
    //       console.log(feedback);
    //     }
    // });
    // $.ajax({
    //     type: 'GET',
    //     url: `/api/users`,
    //     success: function(feedback) {
    //       console.log(feedback);
    //     }
    // });

    /**
     * Testing the POST request for SubscriptionsRestResource
     */
    var csrf_token = "";

    // const payload = {
    //   "user_id": 3,
    //   "tutor_id": 6,
    //   "institute_id": 10,
    // };
    // const payload = {
    //   "user_id": 6,
    //   "free_tutors": 5,
    //   "free_institutes": 5,
    //   "tutors_start_time": 0,
    //   "tutors_end_time": 0,
    //   "institutes_start_time": 0,
    //   "institutes_end_time": 0
    // }

    /**
     * GET, POST and PUT are working fine
     */

    const payload = {
      "free_tutors": 6,
      "free_institutes": 5,
      "tutors_start_time": 100
    };

    $.ajax({
      url: `/rest/session/token`,
      type: 'GET',

      success: function(token) {
        csrf_token = token;
        $.ajax({
          // url: `/subscriptions`,
          url: `/subscriptions-meta`,
          // type: 'POST',
          // type: 'PUT',
          headers: {
            'X-CSRF-TOKEN': csrf_token,
            'Content-Type': 'application/json',
          },
          dataType: 'json',
          data: JSON.stringify(payload),

          success: function(feedback) {
            console.log(feedback);
          }

        });
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
