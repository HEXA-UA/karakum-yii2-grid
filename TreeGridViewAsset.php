<?php

namespace karakum\grid;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the [jQuery TreeGrid plugin library](https://github.com/maxazan/jquery-treegrid)
 *
 * @author Andrey Shertsinger <andrey@shertsinger.ru>
 */
class TreeGridViewAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-treegrid';

    public $js = [
        'js/jquery.treegrid.min.js',
    ];

    public $css = [
        'css/jquery.treegrid.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
