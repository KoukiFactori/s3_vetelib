import $ from 'jquery';
import 'slick-carousel';
import './styles/slider.css';

$('.carrousel').slick({
  dots: true,
  infinite: true,
  speed: 300,
  slidesToShow: 1,
  adaptiveHeight: true,
  autoplay: true,
  autoplaySpeed: 4000,
});