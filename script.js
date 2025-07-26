  const dark = document.querySelector('nav');
const burger = document.querySelector('.burger');
const rightNav = document.querySelector('.topnav');

burger.addEventListener('click', () => {
  const isOpen = rightNav.classList.toggle('show-nav');
  burger.classList.toggle('toggle');

  if (isOpen) {
    dark.style.backgroundColor = "#0a0f1c";
  } else {
    dark.style.backgroundColor = "transparent";
  }
});





  document.addEventListener("DOMContentLoaded", function () {
    const robot = document.querySelector(".robot2");

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            robot.classList.add("animate");
          }
        });
      },
      {
        threshold: 0.5, // Trigger when 50% of the image is in view
      }
    );

    if (robot) {
      observer.observe(robot);
    }
  });