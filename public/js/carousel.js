$(document).ready(function(){
  if(screen.width < 780) {
    $('.autoplay').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
    });
  }else{
    $('.autoplay').slick({
      slidesToShow: 2,
      slidesToScroll: 2,
      autoplay: true,
      autoplaySpeed: 2000,
    });
  }
});



