<?php
/**
 * @var string $warns
 * @var string $success
 */

?>
<?php if($warns):?>

    <div class="notice notice-error">
        <?php foreach( $warns as $w ):?>
            <span><?php echo $w.'<br>'; ?></span>
        <?php endforeach; ?>
    </div>
<?php elseif(isset($_REQUEST['warns']) && !empty($_REQUEST['warns'])):?>
    <div class="notice notice-error">
        <span><?php echo $_REQUEST['warns']; ?></span>
    </div>
<?php endif;?>
<?php if($success):?>

    <div class="notice notice-success">
        <?php foreach( $success as $s ):?>
            <span><?php echo $s.'<br>'; ?></span>
        <?php endforeach; ?>
    </div>
<?php elseif(isset($_REQUEST['success']) && !empty($_REQUEST['success'])):?>
    <div class="notice notice-success">
        <span><?php echo $_REQUEST['success']; ?></span>
    </div>
<?php endif;?>
