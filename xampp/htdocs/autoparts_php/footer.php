</main>
<?php if (!empty($_SESSION['flash'])): ?>
<dialog id="flash">
  <p><?= e($_SESSION['flash']) ?></p>
  <form method="dialog"><button class="btn primary">OK</button></form>
</dialog>
<script>document.getElementById('flash').showModal();</script>
<?php unset($_SESSION['flash']); endif; ?>
</body>
</html>
