<footer></footer>

<!-- Bootstrap JS -->
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Anime.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>

<!-- Custom Script -->
<script src="assets/js/script.js"></script>

<script>
window.addEventListener('DOMContentLoaded', () => {
  const container = document.querySelector('.container-xxl');
  if (container) {
    setTimeout(() => container.classList.add('fade-up-active'), 100);
    setTimeout(() => startTextAnimations(), 550);
  }
});

function animateTitle(selector, delay = 0) {
  const titleWrapper = document.querySelector(selector);
  if (!titleWrapper) return;

  const parent = titleWrapper.closest('.ml6');
  const titleText = titleWrapper.textContent.trim();
  titleWrapper.innerHTML = '';
  parent.style.opacity = 0;

  titleText.split('').forEach(char => {
    const span = document.createElement('span');
    span.textContent = char === ' ' ? '\u00A0' : char;
    span.classList.add('letter');
    titleWrapper.appendChild(span);
  });

  anime.timeline({ delay })
    .add({
      targets: parent,
      opacity: [0, 1],
      duration: 300,
      easing: 'easeOutQuad'
    })
    .add({
      targets: `${selector} .letter`,
      translateY: [100, 0],
      opacity: [0, 1],
      easing: "easeOutExpo",
      duration: 750,
      delay: anime.stagger(50)
    })
    .finished.then(() => {
      titleWrapper.querySelectorAll('.letter').forEach(letter => {
        letter.classList.remove('letter');
        letter.classList.add('expandable');
      });
    });
}

function startTextAnimations() {
  animateTitle('.title-1', 0);
  animateTitle('.title-2', 1000);

  // Typing Effect
  setTimeout(() => {
    typingEffectWithPauses('.description-text-blowup', 40, 500);
  }, 3000);

  // Counter
  setTimeout(() => {
    document.querySelectorAll('.counter').forEach(el => {
      const target = +el.dataset.target;
      const start = el.dataset.start ? +el.dataset.start : 0;
      anime({
        targets: el,
        innerHTML: [start, target],
        easing: 'linear',
        round: 1,
        duration: 8500,
      });
    });
  }, 100);
}


// == Fungsi Typing ==
function typingEffectWithPauses(selector, baseDelay = 40, pauseExtra = 300) {
  const target = document.querySelector(selector);
  if (!target) return;

  const text = target.textContent.trim();
  target.innerHTML = '';
  target.style.opacity = 1;
  target.style.visibility = 'visible';

  const spans = [];
  text.split('').forEach(char => {
    const span = document.createElement('span');
    span.textContent = char === ' ' ? '\u00A0' : char;
    span.classList.add('letter');
    target.appendChild(span);
    spans.push(span);
  });

  let currentDelay = 0;
  const delayMap = spans.map((span) => {
    const isPauseChar = /[.,]/.test(span.textContent);
    const thisDelay = currentDelay;
    currentDelay += baseDelay + (isPauseChar ? pauseExtra : 0);
    return thisDelay;
  });

  anime({
    targets: spans,
    opacity: [0, 1],
    duration: 1,
    delay: (el, i) => delayMap[i],
    easing: 'linear'
  });
}

// === Grain Ink Splash ===
const canvas = document.getElementById('grain-canvas');
const ctx = canvas.getContext('2d');
let width = canvas.width = window.innerWidth;
let height = canvas.height = window.innerHeight;

const particles = [];

window.addEventListener('resize', () => {
  width = canvas.width = window.innerWidth;
  height = canvas.height = window.innerHeight;
});

document.addEventListener('mousemove', e => {
  for (let i = 0; i < 3; i++) {
    particles.push({
      x: e.clientX,
      y: e.clientY,
      vx: (Math.random() - 0.5) * 2,
      vy: (Math.random() - 0.5) * 2,
      alpha: 1,
      radius: Math.random() * 1.5 + 0.5
    });
  }
});

function animateParticles() {
  ctx.clearRect(0, 0, width, height);

  for (let i = particles.length - 1; i >= 0; i--) {
    const p = particles[i];
    p.x += p.vx;
    p.y += p.vy;
    p.alpha -= 0.02;

    ctx.beginPath();
    ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
    ctx.fillStyle = `rgba(0, 0, 0, ${p.alpha})`;
    ctx.fill();

    if (p.alpha <= 0) {
      particles.splice(i, 1);
    }
  }

  requestAnimationFrame(animateParticles);
}
animateParticles();
</script>
</body>
</html>
