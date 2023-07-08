<script src="<?=URL?>public/sources/bootstrap/js/bootstrap.js"></script>
<script src="<?=URL?>public/sources/bootstrap/js/bootstrap.bundle.js"></script>

<?php
    if (isset($jsSources)) {
        foreach ($jsSources as $key => $value) {
            echo "<script src='<?=URL?>public/sources/$value'>";
        }
    }
    ?>

</body>

</html>