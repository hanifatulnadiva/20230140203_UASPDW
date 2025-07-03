</main>
</div>
    <script>
  const notif = document.getElementById('notif');

  function hideNotif() {
    if (notif) {
      notif.style.opacity = '0';
      notif.style.pointerEvents = 'none'; // mencegah notifikasi menutupi menu lain
      setTimeout(() => notif.remove(), 300);
      window.removeEventListener('scroll', hideNotif);
      document.removeEventListener('click', hideNotif);
    }
  }

  window.addEventListener('scroll', hideNotif);
  document.addEventListener('click', hideNotif);
</script>

</body>
</html>