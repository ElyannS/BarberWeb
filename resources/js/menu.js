$(document).ready(function(){


$("body header .container .left a").on('click', function(){
    $('.menu_lateral').toggleClass('active');
    $('body.admin').toggleClass('menu_active');
    
  });
  
  $("body .menu_lateral .closeMenu").on('click', function(){
    $('.menu_lateral').toggleClass('active');
    $('body.admin').toggleClass('menu_active');
  });
  $("header .container .bar").on('click', function(){
      $(this).next().toggleClass('active');
      $(this).children().toggleClass('fa-solid fa-xmark');
      $('body').toggleClass('menu-active')
  });




});
