<div class="block pay-block">
    <?php $is_deposit_completed = is_deposit_completed(); ?>
    <?php $payButtons = get_option('pay-buttons'); ?>
    
    <h1>PAYMENTS <?php echo (!$payButtons['deposit'] && !$payButtons['balance']) ? 'DISABLED' : ''; ?></h1>
    
    <?php if($payButtons['deposit']){ ?>
        <?php $deposit = get_post_by_name('deposit','product') ?>
        <a href="#" id="pay-deposit" class="deposit <?php echo $is_deposit_completed ? 'bloked paid' : ''; ?>" pid="<?php echo $deposit->ID ?>">PAY DEPOSIT & SECURE MY PLACE</a>
    <?php } ?>
    
    <?php if($payButtons['balance']){ ?>
        <?php $balance = get_post_by_name('balance','product') ?>
        <a href="#" id="pay-balance" class="balance <?php echo $is_deposit_completed ? '' : 'bloked unpaid'; ?> <?php echo is_balance_completed() ? 'bloked paid' : ''; ?>" pid="<?php echo $balance->ID ?>">PAY BALANCE</a>
    <?php } ?>
</div>