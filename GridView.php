<?php

namespace karakum\grid;


use yii\helpers\Html;

/**
 * GridView with `.table-responsive` behavior
 * Class extend standard Yii2 GridView and wrap table with div
 *
 * @author Andrey Shertsinger <andrey@shertsinger.ru>
 */
class GridView extends \yii\grid\GridView
{
    /**
     * @var array the HTML attributes for the grid table element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $tableWrapperOptions = ['class' => 'table-responsive'];

    public function renderItems()
    {
        if ($this->tableWrapperOptions) {
            return Html::tag('div', parent::renderItems(), $this->tableWrapperOptions);
        }
        return parent::renderItems();
    }
}