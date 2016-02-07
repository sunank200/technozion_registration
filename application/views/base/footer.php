                </div>
                <!-- <div id="footer" class=" hidden-print">
                    <p class="help-block">&copy; <?php echo date('Y'); ?>,  Technozion, NIT Warangal</p>
                </div> -->
            </div>
        </div>
    </div>
    <script src="<?php echo asset_url()."js/jquery.min.js"; ?>"></script>
    <script src="<?php echo asset_url()."js/bootstrap.min.js"; ?>"></script>
    <?php
    if (isset($scripts)) {
        foreach ($scripts as $index => $script) {
            ?>
            <script src="<?php echo $script; ?>"></script>
            <?php
        }
    }
    ?>
    <script>
        $('.tips').tooltip()
    </script>
</body>
</html>