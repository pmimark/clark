<style>
    #pay-opt{
        padding: 50px;
    }
    #pay-opt label{
        display: block;
        padding: 0 0 10px;
    }
</style>
<div id="pay-opt">
    <form action="" method="POST">
        <?php 
            $data = get_option('pay-buttons');
        ?>
        <label><input <?php echo $data['deposit'] ? 'checked="on"' : ''; ?> type="checkbox" name="deposit" /> show deposit button?</label>
        <label><input <?php echo $data['balance'] ? 'checked="on"' : ''; ?> type="checkbox" name="balance" /> show balance button?</label>
        <input class="button button-primary button-large" type="submit" name="save" value="Save" />
    </form>
</div>