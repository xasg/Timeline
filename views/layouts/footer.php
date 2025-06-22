    <footer>
        <p><strong>10 AÑOS ANUIES TIC</strong></p>
        <p>Una década de innovación y colaboración en la educación superior mexicana</p>
    </footer>

    <script src="assets/js/timeline.js"></script>
    <?php if (isset($additionalScripts)): ?>
        <?php foreach ($additionalScripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>