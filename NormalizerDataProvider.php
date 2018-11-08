<?php

namespace karakum\grid;


use yii\data\BaseDataProvider;
use yii\data\DataProviderInterface;
use yii\helpers\ArrayHelper;

/**
 * Data provider wrapper for build sorted tree
 *
 * @author Andrey Shertsinger <andrey@shertsinger.ru>
 */
class NormalizerDataProvider extends BaseDataProvider
{
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

    private $_dataProvider;

    public function __construct($dataProvider, $config = [])
    {
        $this->_dataProvider = $dataProvider;
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();

        $this->setPagination(false);
    }

    /**
     * Prepares the data models that will be made available in the current page.
     * @return array the available data models
     */
    protected function prepareModels()
    {
        /** @var DataProviderInterface $dp */
        $dp = $this->_dataProvider;
        return $this->normalizeData($dp->getModels(), $this->parentRootValue);
    }

    /**
     * Prepares the keys associated with the currently available data models.
     * @param array $models the available data models
     * @return array the keys
     */
    protected function prepareKeys($models)
    {
        return ArrayHelper::getColumn($models, $this->keyColumnName);
    }

    /**
     * Returns a value indicating the total number of data models in this data provider.
     * @return integer total number of data models in this data provider.
     */
    protected function prepareTotalCount()
    {
        return $this->getCount();
    }

    /**
     * Normalize tree data
     * @param array $data
     * @param string $parentId
     * @return array
     */
    protected function normalizeData(array $data, $parentId = null)
    {
        $result = [];
        foreach ($data as $element) {
            if ($element[$this->parentColumnName] == $parentId) {
                $result[] = $element;
                $children = $this->normalizeData($data, $element[$this->keyColumnName]);
                if ($children) {
                    $result = array_merge($result, $children);
                }
            }
        }
        return $result;
    }
}
