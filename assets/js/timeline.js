document.addEventListener('DOMContentLoaded', function() {
  // Intersection Observer for animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, observerOptions);

  // Observe all timeline items
  document.querySelectorAll('.timeline-item').forEach(item => {
    observer.observe(item);
  });
});

// Toggle extended content
function toggleContent(id) {
  const content = document.getElementById('content-' + id);
  const button = content.previousElementSibling;
  
  if (content.style.display === 'none' || content.style.display === '') {
    content.style.display = 'block';
    button.textContent = 'Leer menos';
  } else {
    content.style.display = 'none';
    button.textContent = 'Leer más';
  }
}