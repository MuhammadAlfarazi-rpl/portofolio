<footer></footer>

<!-- Bootstrap JS -->
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Anime.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

<!-- Three.js -->
<script src="https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js"></script>


<!-- Vanila Tilt -->
<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.7.2/dist/vanilla-tilt.min.js"></script>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>

<!-- Custom Script -->
<script src="assets/js/script.js"></script>

<script>
// == Navigation Bar ==
const navLinks = document.querySelectorAll('.nav-link');

navLinks.forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();

    navLinks.forEach(i => i.classList.remove('selected'));

    link.classList.add('selected');
  });
});

// == Sphere ==
function fitElementToParent(el, padding) {
  var timeout = null;
  function resize() {
    if (timeout) clearTimeout(timeout);
    anime.set(el, {scale: 1});
    var pad = padding || 0;
    var parentEl = el.parentNode;
    var elOffsetWidth = el.offsetWidth - pad;
    var parentOffsetWidth = parentEl.offsetWidth;
    var ratio = parentOffsetWidth / elOffsetWidth;
    timeout = setTimeout(anime.set(el, {scale: ratio}), 10);
  }
  resize();
  window.addEventListener('resize', resize);
}

var sphereAnimation = (function() {

  var sphereEl = document.querySelector('.sphere-animation');
  var spherePathEls = sphereEl.querySelectorAll('.sphere path');
  var pathLength = spherePathEls.length;
  var hasStarted = false;
  var aimations = [];

  fitElementToParent(sphereEl);

  var breathAnimation = anime({
    begin: function() {
      for (var i = 0; i < pathLength; i++) {
        aimations.push(anime({
          targets: spherePathEls[i],
          stroke: {value: ['rgba(255,75,75,1)', 'rgba(80,80,80,.35)'], duration: 500},
          translateX: [2, -4],
          translateY: [2, -4],
          easing: 'easeOutQuad',
          autoplay: false
        }));
      }
    },
    update: function(ins) {
      aimations.forEach(function(animation, i) {
        var percent = (1 - Math.sin((i * .35) + (.0022 * ins.currentTime))) / 2;
        animation.seek(animation.duration * percent);
      });
    },
    duration: Infinity,
    autoplay: false
  });

  var introAnimation = anime.timeline({
    autoplay: false
  })
  .add({
    targets: spherePathEls,
    strokeDashoffset: {
      value: [anime.setDashoffset, 0],
      duration: 3900,
      easing: 'easeInOutCirc',
      delay: anime.stagger(190, {direction: 'reverse'})
    },
    duration: 2000,
    delay: anime.stagger(60, {direction: 'reverse'}),
    easing: 'linear'
  }, 0);

  var shadowAnimation = anime({
      targets: '#sphereGradient',
      x1: '25%',
      x2: '25%',
      y1: '0%',
      y2: '75%',
      duration: 30000,
      easing: 'easeOutQuint',
      autoplay: false
    }, 0);

  function init() {
    introAnimation.play();
    breathAnimation.play();
    shadowAnimation.play();
  }
  
  init();

})();

// == Fade in ==
window.addEventListener('load', () => {
    document.querySelector('.fade-up-init').classList.add('fade-up-show');
  });

// == Typing Effect ==
function typingEffectStrong(selector, baseDelay = 100, pauseExtra = 700) {
  const container = document.querySelector(selector);
  if (!container) return;

  const heading = container.querySelector('h1');
  if (!heading) return;

  const originalHTML = heading.innerHTML;
  container.innerHTML = ''; // clear container

  const tempDiv = document.createElement('div');
  tempDiv.innerHTML = originalHTML;

  let totalDelay = 0;
  const h1 = document.createElement('h1');
  container.appendChild(h1);

  function processNode(node) {
    if (node.nodeType === Node.TEXT_NODE) {
      node.textContent.split('').forEach(char => {
        const span = document.createElement('span');
        span.textContent = char === ' ' ? '\u00A0' : char;
        span.classList.add('letter');
        h1.appendChild(span);
      });
    } else if (node.nodeType === Node.ELEMENT_NODE && node.tagName === 'STRONG') {
      const strong = document.createElement('strong');
      h1.appendChild(strong);
      node.textContent.split('').forEach(char => {
        const span = document.createElement('span');
        span.textContent = char === ' ' ? '\u00A0' : char;
        span.classList.add('letter');
        strong.appendChild(span);
      });
    }
  }

  tempDiv.childNodes.forEach(processNode);

  const spans = h1.querySelectorAll('.letter');

  anime({
    targets: spans,
    opacity: [0, 1],
    translateY: ['-10px', '0px'],
    duration: 300,
    delay: (el, i) => totalDelay + (i * baseDelay) + (/[.,]/.test(el.textContent) ? pauseExtra : 0),
    easing: 'easeOutExpo'
  });
}

setTimeout(() => {
  typingEffectStrong('.description-text-blowup', 100, 700);
}, 1000);

</script>


</body>
</html>
