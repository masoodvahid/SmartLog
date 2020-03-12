var reqTimeout;
var sync_time;

$.get("config.php?sync_time=yes", function(data){
  sync_time = data;
  console.log('sync_time:' + data);
})

function logFileMonitor(filter,isFirstRun) {
  
  if($.isNumeric(sync_time)){
    sync_time = sync_time;
  }else{
    sync_time = 5000
  }
  $.ajax({        
    type: 'GET', 
    url: 'core/core.php', 
    data: { request: 'start', filter: filter, isFirstRun: isFirstRun }, 
    dataType: 'json',           
    success: function(data) {
      if (data.status == true){  
        $('#keeplive').text(data.time);      
        if (data.message != '.'){
          $('#tail').prepend(data.message.split('\n').join('<br />')+"<br />");          
        }
      }else{
        $('#tail').prepend('<br><span style="color: yellow"><i class="icofont-warning"></i> ERROR : '+data.message+'</span>');
      }
    },
    complete: function(xhr){      
      reqTimeout = setTimeout(function() {
        logFileMonitor(filter, "0");
      }, sync_time) 
    }
  });  
  return false;
};     

function initializer(){      
  if(!$("#tail").hasClass('mute') && $(this).data("sound") !='-' ){
    var sound = $(this).data("sound");
    if (sound == ''){
      sound = 'alarm1.mp3';
    }
    var audio = new Audio('sounds/'+sound);
    audio.play();
    $.alert({
      columnClass: 'small',
      theme: 'supervan',  // material, light, dark, bootstrap        
      title: $(this).data("word"),
      content: $(this).text(),
      buttons: {
        Confirmed: function () {
            // here the button key 'hey' will be used as the text.
            audio.pause();
        },            
      }
    });
  }    
}

function clear(){
  $('#tail').empty();
}

function mute(){
  if($("#tail").hasClass('mute')){
    $('#tail').removeClass('mute');
    $("#mute").html('<i class="icofont-volume-mute"></i> Mute');
  }else{
    $('#tail').addClass('mute');
    $("#mute").html("<i class='icofont-alarm'></i> Unmute");
  }
}

function lock(){
  $('#tail').addClass('blur');
  $('#lockscreen').show("slide");
  $('#password').val('');
  $('#error').empty();
  if(!$("#tail").hasClass('mute')){
    $('#tail').addClass('mute');
    $("#mute").html('<i class="icofont-alarm"></i> Unmute');
  }
}

function unlock(){
  $.get("config.php?login="+$("#username").val(), function(data){
    if ($.md5($("#password").val()) == data){
      $('#lockscreen').hide("slide");
      $('#tail').removeClass('blur');
      mute();
    }else{
      $('#error').text("Invalid Username or Password");
    }
  })  
}

function enter() {
  if (event.which == 13) unlock();
}

function filter(){   
  var keyword = $(this).val();
  $('#tail').children().show();
  // console.log('cancelled_synced_req_id: 'reqTimeout + '  sync_time: ' + sync_time);
  clearTimeout(reqTimeout);  
  if( keyword != 'show_all'){
    $('#tail').children().hide();
    $('#tail > .'+keyword).show();  
    logFileMonitor(keyword,"0");      
  }else{
    logFileMonitor("none","0");
    $('#tail').children().show();        
  }
}

function search_box(){
  $(".search").slideToggle('fast','swing');
  $("#search_count").text('0');
  $("#search_input").select().val('');
}

function search(){     
  var keyword = $(this).val() , count = 0;
  $('#tail').children().each(function(){          
      if ($(this).text().search(new RegExp(keyword, "i")) < 0) {
          $(this).fadeOut();
      } else {
          $(this).show();
          count++;
      }
  });      
  $("#search_count").text(count);
}