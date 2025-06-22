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

  // Share functionality
  // Share functionality
  document.querySelectorAll('.x-share-btn').forEach(button => {
    button.addEventListener('click', function() {
      const title = this.dataset.title;
      const url = this.dataset.url;
      const text = `Écha un vistazo a este evento en la timeline de ANUIES-TIC: ${title}`;
      const shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
      window.open(shareUrl, '_blank');
    });
  });

  document.querySelectorAll('.facebook-share-btn').forEach(button => {
    button.addEventListener('click', function() {
      const url = this.dataset.url;
      const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
      window.open(shareUrl, '_blank');
    });
  });

  document.querySelectorAll('.whatsapp-share-btn').forEach(button => {
    button.addEventListener('click', function() {
      const title = this.dataset.title;
      const url = this.dataset.url;
      const text = `Écha un vistazo a este evento en la timeline de ANUIES-TIC: ${title} ${url}`;
      const shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;
      window.open(shareUrl, '_blank');
    });
  });
  // Ensure toggleContent is globally accessible if called from HTML onclick
  window.toggleContent = toggleContent;
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

// Share functionality
document.querySelectorAll('.x-share-btn').forEach(button => {
  button.addEventListener('click', function() {
    const title = this.dataset.title;
    const url = this.dataset.url;
    const text = `Écha un vistazo a este evento en la timeline de ANUIES-TIC: ${title}`;
    const shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
    window.open(shareUrl, '_blank');
  });
});

document.querySelectorAll('.facebook-share-btn').forEach(button => {
  button.addEventListener('click', function() {
    const url = this.dataset.url;
    const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
    window.open(shareUrl, '_blank');
  });
});

document.querySelectorAll('.whatsapp-share-btn').forEach(button => {
  button.addEventListener('click', function() {
    const title = this.dataset.title;
    const url = this.dataset.url;
    const text = `Écha un vistazo a este evento en la timeline de ANUIES-TIC: ${title} ${url}`;
    const shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;
    window.open(shareUrl, '_blank');
  });
});