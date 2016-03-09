<?php
use yii\helpers\Html;
use humhub\modules\cfiles\controllers\BrowseController;
?>
<ol class="breadcrumb" dir="ltr">
<?php foreach ($crumb as $parentFolder): ?>
    <li><a
        href="<?php echo $contentContainer->createUrl('index', ['fid' => $parentFolder->id]); ?>">
    <?php echo $parentFolder->id == BrowseController::ROOT_ID ? '<i class="fa fa-home fa-lg fa-fw"></i>' : Html::encode($parentFolder->title); ?></a></li>
<?php endforeach; ?>
</ol>

<div id="cfiles-log"></div>

<?php if(sizeof($items) > 0 || $allPostedFilesCount > 0) : ?>
<div class="table-responsive">
    <table id="bs-table" class="table table-hover">
        <thead>
            <tr>
                <th class="text-right">
                    <?php echo Html::checkbox('allchk', false, [ 'class' => 'allselect']); ?></th>
                <th class="text-left"><?php echo Yii::t('CfilesModule.base', 'Name'); ?></th>
                <th class="hidden-xs text-right"><?php echo Yii::t('CfilesModule.base', 'Size'); ?></th>
                <th class="text-right"><?php echo Yii::t('CfilesModule.base', 'Creator'); ?></th>
                <th class="hidden-xxs text-right"><?php echo Yii::t('CfilesModule.base', 'Updated'); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td class="hidden-xs"></td>
                <td class="hidden-xxs"></td>
            </tr>
        </tfoot>
        <?php if ($allPostedFilesCount > 0) : ?>
            <tr data-type="all-posted-files"
            data-url="<?php echo $contentContainer->createUrl('all-posted-files'); ?>"
            data-id="<?php echo 'folder_'.BrowseController::All_POSTED_FILES_ID; ?>">
            <td></td>
            <td class="text-left title">
                <div class="title">
                    <i class="fa fa-folder fa-fw"></i>&nbsp;
                    <a
                    href="<?php echo $contentContainer->createUrl('all-posted-files'); ?>">
                            <?php echo Yii::t('CfilesModule.base', 'All posted files'); ?> (<?php echo ''. $allPostedFilesCount; ?>)
                    </a>
                </div>
            </td>
            <td></td>
            <td class="hidden-xs"></td>
            <td class="hidden-xxs"></td>
        </tr>
        <?php endif; ?>
        <?php foreach ($items as $item) : ?>
        <tr data-type="<?php echo $item->getItemType(); ?>"
            data-id="<?php echo $item->getItemId(); ?>"
            data-url="<?php echo $item->getUrl(true); ?>">
            <td class="text-muted text-right">
                <?php echo Html::checkbox('selected[]', false, [ 'value' => $item->getItemId(), 'class' => 'multiselect']); ?>
            </td>
            <td class="text-left">
                <div class="title">
                    <i class="fa <?php echo $item->getIconClass(); ?> fa-fw"></i>&nbsp;
                    <?php if ($item->getItemType() === "image") : ?>
                    <a class="preview-link" data-toggle="lightbox"
                        href="<?php echo $item->getUrl(); ?>#.jpeg"
                        data-footer='
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo Yii::t('FileModule.base', 'Close'); ?></button>'>
                        <?php echo Html::encode($item->getTitle()); ?>
                    </a>
                    <?php else : ?>
                    <a href="<?php echo $item->getUrl(); ?>">
                        <?php echo Html::encode($item->getTitle()); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </td>
            <td class="hidden-xs text-right">
                <div class="size pull-right">
                    <?php if ($item->getSize() == 0): ?> 
                        &mdash;
                    <?php else: ?>
                        <?php echo Yii::$app->formatter->asShortSize($item->getSize(), 1); ?>
                    <?php endif; ?>
                </div>
            </td>
            <td class="text-right">
                <div class="creator pull-right">
                    <a href="<?php echo $item->creator->createUrl(); ?>">
                        <img class="img-rounded tt img_margin"
                            src="<?php echo $item->creator->getProfileImage()->getUrl(); ?>"
                            width="21" height="21" alt="21x21" data-src="holder.js/21x21"
                            style="width: 21px; height: 21px;"
                            data-original-title="<?php echo $item->creator->getDisplayName();?>"
                            data-placement="top" title="" data-toggle="tooltip">
                    </a>
                </div>
            </td>
            <td class="hidden-xxs text-right">
                <div class="timestamp pull-right">
                    <?php echo \humhub\widgets\TimeAgo::widget([ 'timestamp' => $item->content->updated_at ]); ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php else : ?>
<div class="folderEmptyMessage">
    <div class="panel">
        <div class="panel-body">
            <p><strong><?php echo Yii::t('CfilesModule.base', 'This folder is empty.');?></strong></p>
            <?php if($this->context->canWrite()): ?>
            <?php echo Yii::t('CfilesModule.base', 'Upload files or create a subfolder with the buttons on the top.');?>
            <?php else: ?>
            <?php echo Yii::t('CfilesModule.base', 'Unfortunately you have no permission to upload/edit files.');?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<script>
    $(function () {
        initFileList();
    });
</script>