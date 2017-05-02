<style>
    #mcca-import{
        overflow: hidden;
    }
    .error{
        color: red;
    }
    .save{
        color: green;
    }
</style>
<div id="mcca-import">
    <h2>MCCA Import Users from CSV file</h2>
    <form action="tools.php?page=mcc-import-users" method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" />
        <input type="submit" value="Import!" class="button button-primary button-large" />
    </form>
    <?php
        if(!empty($_FILES['csv_file'])){
            self::import_users();
        }
    ?>
</div>