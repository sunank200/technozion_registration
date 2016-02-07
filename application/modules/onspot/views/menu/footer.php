<?php
    if (isset($scripts)) {
        foreach ($scripts as $index => $script) {
            ?>
                        <script src="<?php echo $script; ?>"></script>

            <?php
        }
        unset($scripts[0]);
    }
    ?>

</body>
</html>