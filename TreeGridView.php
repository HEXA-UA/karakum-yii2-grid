<?php

namespace karakum\grid;


use Closure;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * TreeGridView renders a jQuery TreeGrid component.
 * Class extend standard Yii2 GridView
 *
 * @see https://github.com/maxazan/jquery-treegrid
 * @author Andrey Shertsinger <andrey@shertsinger.ru>
 */
class TreeGridView extends GridView
{

    /**
     * @var string data sorter class
     * Defaults to 'karakum\grid\NormalizerDataProvider'.
     */
    public $normalizerClassName;

    /**
     * @var string name of key column used to build tree
     */
    public $keyColumnName = 'id';

    /**
     * @var string name of parent column used to build tree
     */
    public $parentColumnName = 'parent_id';

    /**
     * @var mixed parent column value of root elements from data
     */
    public $parentRootValue = null;

    /**
     * @var array The plugin options
     */
    public $pluginOptions = [];

    private $_rowOptions;

    public function init()
    {
        if (!$this->keyColumnName) {
            throw new InvalidConfigException('The "keyColumnName" property must be specified"');
        }
        if (!$this->parentColumnName) {
            throw new InvalidConfigException('The "parentColumnName" property must be specified"');
        }

        if ($this->rowOptions) {
            $this->_rowOptions = $this->rowOptions;
        }
        $this->rowOptions = function ($model, $key, $index, $grid) {
            if ($grid->_rowOptions instanceof Closure) {
                $options = call_user_func($grid->_rowOptions, $model, $key, $index, $grid);
            } else {
                $options = $grid->_rowOptions;
            }

            $id = ArrayHelper::getValue($model, $grid->keyColumnName);
            Html::addCssClass($options, "treegrid-$id");

            $parentId = ArrayHelper::getValue($model, $grid->parentColumnName);
            if ($parentId) {
                if (ArrayHelper::getValue($grid->pluginOptions, 'initialState') == 'collapsed') {
                    Html::addCssStyle($options, 'display: none;');
                }
                Html::addCssClass($options, "treegrid-parent-$parentId");
            }

            return $options;
        };

        $this->dataProvider = \Yii::createObject([
            'class' => $this->normalizerClassName ?: NormalizerDataProvider::className(),
            'keyColumnName' => $this->keyColumnName,
            'parentColumnName' => $this->parentColumnName,
            'parentRootValue' => $this->parentRootValue,
        ], [$this->dataProvider]);

        parent::init();
    }

    public function run()
    {
        $id = $this->options['id'];
        $options = Json::htmlEncode($this->pluginOptions);
        $view = $this->getView();
        TreeGridViewAsset::register($view);
        $view->registerJs("jQuery('#$id table').treegrid($options);");
        parent::run();
    }
}
