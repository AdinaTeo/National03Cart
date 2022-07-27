<div class="row">
    <div class="col-12">
        <?php
           if(isset($_SESSION['error_message'])):
        ?>
        <div class="alert alert-danger" role="alert">
            <?php
              echo $_SESSION['error_message'];
              unset($_SESSION['error_message']);
            ?>
        </div>
        <?php endif; ?>
        <?php
        if(isset($_SESSION['success_message'])):
            ?>
            <div class="alert alert-success" role="alert">
                <?php
                echo $_SESSION['success_message'];
                unset($_SESSION['success_message']);
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>
