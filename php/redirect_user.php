
<?php
/*=====
    function redirect
        this function used to redirect after displaying message.
       
       by: Colton Boyd
       last modified: 2023-12-6
   =====*/
function redirect($redirectUrl) {
    ?>
    <script>
        // Redirect after 5 seconds (5000 milliseconds)
        setTimeout(function() {window.location.href = "<?= $redirectUrl ?>";}, 1000);
    </script>
    <?php
    // You may choose to exit here to prevent further content from being sent
    exit;
}
?>