<?php use yii\helpers\Html; ?>
<ol class="breadcrumb" dir="ltr">
    <li><a
        href="<?php echo $contentContainer->createUrl('index', ['fid' => 0]); ?>"><i
            class="fa fa-home fa-lg fa-fw"></i> </a></li>
    <?php foreach ($crumb as $parentFolder): ?>
    <li><a
        href="<?php echo $contentContainer->createUrl('index', ['fid' => $parentFolder->id]); ?>">
            <?php echo Html::encode($parentFolder->title); ?></a></li>
    <?php endforeach; ?>
</ol>

<ul id="log">

</ul>

<div class="table-responsive">
    <table id="bs-table" class="table table-hover">
        <thead>
            <tr>
                <th class="text-right" data-sort="int">
                    <?php echo Html::checkbox( 'allchk', false, [ 'class'=> 'allselect']); ?></th>
                <th class="col-sm-5 text-left" data-sort="string">Name</th>
                <th class="col-sm-2 text-right" data-sort="int">Size</th>
                <th class="col-sm-2 text-right" data-sort="string">Creator</th>
                <th class="col-sm-3 text-right" data-sort="int">Updated</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="5"></td>
            </tr>
        </tfoot>
        <?php if ($folderId==0 ) : ?>
        <tr data-type="all-posted-files"
            data-url="<?php echo $contentContainer->createUrl('all-posted-files'); ?>">
            <td></td>
            <td class="text-left"><i class="fa fa-folder fa-fw"></i>&nbsp;
                <a
                href="<?php echo $contentContainer->createUrl('all-posted-files'); ?>">
                    <?php echo Yii::t( 'CfilesModule.views_browse_editFolder', 'All posted files'); ?>
                </a></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php endif; ?>
        <?php foreach ($items as $item) : ?>
        <tr data-type="<?php echo $item->getItemType(); ?>"
            data-id="<?php echo $item->getItemId(); ?>"
            data-url="<?php echo $item->getUrl(); ?>">
            <td class="text-muted text-right">
                <?php echo Html::checkbox( 'selected[]', false, [ 'value'=> $item->getItemId(), 'class' => 'multiselect']); ?>
            </td>
            <td class="text-left" data-sort-value="icon examples"><i
                class="fa <?php echo $item->getIconClass(); ?> fa-fw"></i>&nbsp;
                <?php if ($item->getItemType() === "image") : ?>
                <a class="preview-link" data-toggle="lightbox" href="<?php echo $item->getUrl(); ?>#.jpeg" data-footer='<button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo Yii::t('FileModule.widgets_views_showFiles', 'Close'); ?></button>'><?php echo Html::encode($item->getTitle()); ?></a>
                <?php else : ?>
                <a href="<?php echo $item->getUrl(); ?>">
                    <?php echo Html::encode($item->getTitle()); ?>
                </a>
                <?php endif; ?>
            </td>
            <td class="text-right"
                data-sort-value="<?php echo $item->getSize(); ?>">
                <?php if ($item->getSize() == 0): ?> &mdash;
                <?php else: ?>
                <?php echo Yii::$app->formatter->asShortSize($item->getSize(), 1); ?>
                <?php endif; ?>
            </td>
            <td class="text-right" data-sort-value="" title=""><a
                href="<?php echo $item->creator->createUrl(); ?>">
                    <?php echo $item->creator->username?>
                </a></td>

            </td>
            <td class="text-right" data-sort-value="" title="">
                <?php echo \humhub\widgets\TimeAgo::widget([ 'timestamp'=> $item->content->updated_at]); ?>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>
</div>
<script>
    $(function() {
        initFileList();
    });
</script>