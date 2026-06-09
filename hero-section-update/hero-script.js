
    $('#sestate').click(function(){
    $('#state').slideToggle();
});

$('#sesubser').click(function(){
    $('#subser').slideToggle();
});
    $().ready(function(){
    var web_host = 'https://itzeazy.in/';

  

   
      $('#sestate').mouseenter(function(){

        var id=$(this).attr('name');
        
        $('#'+id).slideDown();
      });
      $('#seserv').mouseenter(function(){
      if($('#sspan').text()=='Choose Location'){
      }else{
        var id=$(this).attr('name');
        
        $('#'+id).slideDown();
        }
      });

      $('#sesubser').mouseenter(function(){
      if($('#css').text()=='Choose Service'){
      }else{
        var id=$(this).attr('name');
        
        $('#'+id).slideDown();
        }
      });
      $('.searchone').mouseleave(function(){
        $('.bss').hide();
      });

      $('.state').click(function(){
      var tes=$(this).text();
          var tesVal=$(this).attr('name');
          // alert(tesVal);
      $('#sspan').text(tes);
          $('#sspan').attr('name',tesVal);
          $('#state').hide();
      });
      $('.servic').click(function(){

        // alert($('#sspan').text());
      if($('#sspan').text()=='Choose City'){
        swal({
              icon: "error",
              title: "Oops...",
              text: "Please First Select City!",
              position: "top-end",
              showConfirmButton: false,
              timer: 15000,
            });
      //alert('Please Select State');
      }else{
      var tes=$(this).text();
      $('#css').text(tes);
      var id=$(this).attr('name');
      $('.subser').hide();
      $('.'+id).show();
          $('#ser').hide();
      }
      //$('#searcbar').width('800px');
        $('#viscon').hide();
      });

$('.subser').click(function(){

    var tes = $(this).text().trim();
    var id = $(this).attr('name');

    $('#css').text(tes);
    $('#css').attr('data-value', id);

    $('#subser').hide();
});
      $('#search').click(function(){
      var service = $('#css').text();  
      var pathname = window.location.pathname;
      var lang="";    
      var stat=$('#sspan').attr('name').toLowerCase().trim();   
      var ser = $('#css').attr('data-value');
      if(stat==''){
        swal({
              icon: "error",
              title: "Oops...",
              text: "Please Select City!",
              position: "top-end",
              showConfirmButton: false,
              timer: 15000,
            })
            return false;      
      }else if(ser ==''){
        swal({
              icon: "error",
              title: "Oops...",
              text: "Please Select Service!",
              position: "top-end",
              showConfirmButton: false,
              timer: 15000,
            })
            return false;
      }else if((ser =='') && (stat=='')){
        // alert('choose city');
        swal({
              icon: "error",
              title: "Oops...",
              text: "Please Select City and Service!",
              position: "top-end",
              showConfirmButton: false,
              timer: 15000,
            })
            return false;
      } else {
          
          if(ser =='rto/re-registeration'){
              var link = web_host+lang+''+stat+'/'+ser;
          }else if(ser.includes("visa")){
                 var link = web_host+lang+''+ser;
          }else{
              var link = web_host+lang+''+stat+'/'+ser+'-in-'+stat;
          }

      location.href=link;
      }
    });   
});
