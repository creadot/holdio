// const lenis = new Lenis();

// // Use requestAnimationFrame to continuously update the scroll
// function raf(time) {
//   lenis.raf(time);
//   requestAnimationFrame(raf);
// }

// requestAnimationFrame(raf);



let lenis = new Lenis();


function raf(time) {
  lenis.raf(time);
  requestAnimationFrame(raf);
}
requestAnimationFrame(raf);

$(document).on('beforeShow.fb', function() {
  lenis.destroy();
});

$(document).on('afterClose.fb', function() {
  lenis = new Lenis();
  requestAnimationFrame(raf);
});