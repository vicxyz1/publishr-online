
<style>

</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>
                    Statistics! <small>check performance</small>
                </h1>
            </div>
            <h3 class="text-muted">
                Most viewed photos
            </h3>

            <?php if (isset($this->err_msg)): ?>
                <p class="label label-danger"><?= $this->err_msg ?></p>
            <?php endif ?>







        </div>
    </div>
    <div class="row">
        <?php $i = 1;
        foreach ($this->photos as $photo): ?>

            <div class="col-xs-6 col-md-2">
                <div class="thumbnail">
                    <img src="<?= $photo['url_q'] ?>" alt="<?= $photo['title'] ?>">
                    <div class="caption">
                        <h3><?= $photo['title'] ?></h3>
                        <p><?= $photo['views'] ?> views</p>

                    </div>
                </div>
            </div>
            <?php if ($i++ % 6 == 0): ?></div><div class="row" ><?php endif ?>
<?php endforeach; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3>Total views: <?=$this->total_views?></h3>
    </div>
    
</div>
<script>


</script>