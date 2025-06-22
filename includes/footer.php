<footer></footer>

<!-- Bootstrap JS -->
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Anime.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

<!-- Vanila Tilt -->
<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.7.2/dist/vanilla-tilt.min.js"></script>

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
  const container = document.querySelector(selector);
  if (!container) return;

  // Ambil semua <p> di dalam .description-text-blowup
  const paragraphs = Array.from(container.querySelectorAll('p'));
  container.innerHTML = ''; // clear container
  container.style.opacity = 1;
  container.style.visibility = 'visible';

  let totalDelay = 0;

  paragraphs.forEach((para, index) => {
    const text = para.textContent.trim();
    const p = document.createElement('p');
    container.appendChild(p);

    text.split('').forEach((char, i) => {
      const span = document.createElement('span');
      span.textContent = char === ' ' ? '\u00A0' : char;
      span.classList.add('letter');
      p.appendChild(span);
    });

    const spans = p.querySelectorAll('.letter');
    anime({
      targets: spans,
      opacity: [0, 1],
      duration: 1,
      delay: (el, i) => totalDelay + (i * baseDelay) + (/[.,]/.test(el.textContent) ? pauseExtra : 0),
      easing: 'linear'
    });

    totalDelay += spans.length * baseDelay + pauseExtra;
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

const palette = ['#ff6b6b', '#feca57', '#54a0ff', '#5f27cd', '#00d2d3', '#1dd1a1', '#ff9ff3'];


document.addEventListener('mousemove', e => {
  for (let i = 0; i < 3; i++) {
    particles.push({
      x: e.clientX,
      y: e.clientY,
      vx: (Math.random() - 0.5) * 2,
      vy: (Math.random() - 0.5) * 2,
      alpha: 1,
      radius: Math.random() * 1.5 + 0.5,
      color: palette[Math.floor(Math.random() * palette.length)] 
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
    ctx.fillStyle = hexToRgba(p.color, p.alpha);
    ctx.fill();

    if (p.alpha <= 0) {
      particles.splice(i, 1);
    }
  }

  requestAnimationFrame(animateParticles);
}
animateParticles();

function hexToRgba(hex, alpha) {
  const r = parseInt(hex.slice(1, 3), 16);
  const g = parseInt(hex.slice(3, 5), 16);
  const b = parseInt(hex.slice(5, 7), 16);
  return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}

// == Tilt ==
  VanillaTilt.init(document.querySelectorAll(".hero-card"), {
    max: 2,
    speed: 100,
    glare: true,
    "max-glare": 0.2,
    scale: 1.02,
    easing: "cubic-bezier(.03,.98,.52,.99)"
  });
</script>
</body>
</html>
