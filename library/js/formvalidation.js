$(document).ready(function () {
 
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        var target = $(e.target);

          if (target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {
       var active = $('.wizard .nav-tabs li.active');
        active.next().removeClass('disabled');
        var fname = $('#fname').val();
        var addmis_for = $('#addmis_for').val();
        var gender = $('#gender').val();
        var dob = $('#dob').val();        
        var aadhar_no = $('#aadhar_no').val();
        var category = $('#category').val();
        var cast = $('#cast').val();
        var address = $('#address').val();
        var dist = $('#dist').val();
        var pin_code = $('#pin_code').val();
        var contact_one = $('#contact_one').val();
        var contact_two = $('#contact_two').val();
        if(fname==""){
            swal("Full name required")
            .then((value) => {
               $( "#fname" ).focus();
               
            });
            return false;
         }
         if(contact_one=="" || contact_one.length!=10){
            swal("Mobile number required")
            .then((value) => {
               $( "#contact_one" ).focus();
               
            });
            return false;
         }
         nextTab(active);
    });

    $(".prev-step").click(function (e) {

        var active = $('.wizard .nav-tabs li.active');

        prevTab(active);

    });

    $(".finish").click(function (e) {
      var image = $("#image").val();
      var tenth_att = $("#tenth_att").val();
      var twel_att = $("#twel_att").val();
      var tc_att = $("#tc_att").val();
      var aadhar_att = $("#aadhar_att").val();
     
       // alert("sdfdsf");
      if(image==""){
            swal("Passport photo required")
            .then((value) => {
               $( "#image" ).focus();
               
            });
            return false;
         }
         });

    $(".next-step2").click(function (e) {
      var active = $('.wizard .nav-tabs li.active');
      active.next().removeClass('disabled');
        nextTab(active);
    });

    $(".next-step3").click(function (e) {
      var active = $('.wizard .nav-tabs li.active');
      active.next().removeClass('disabled');
      nextTab(active);
    });


});

function nextTab(elem) {
  //alert('sdfsdf');
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}


$('.nav-tabs').on('click', 'li', function() {
    $('.nav-tabs li.active').removeClass('active');  
    $(this).addClass('active');      
});


  $(document).ready(function () {
   $("#repassword").keyup(function(){
     var password = $("#password").val();
      // alert(password);
      var repassword = $("#repassword").val();
      if(password != repassword){
        // alert("Password do not match.").;
        $("#check").css("color","red");
        $("#check").text("Password does't matched");  
         return false;
         }
         else{
          $("#check").css("color","green");
          $("#check").text("Password match");
          $("#repassword").css("border-color","green");
          return true;  
      } 
    });
  });
       