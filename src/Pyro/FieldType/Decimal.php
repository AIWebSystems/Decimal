<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * Decimal Field Type
 * @author        Ryan Thompson - AI Web Systems, Inc.
 * @copyright    Copyright (c) 208 - 2012, AI Web Systems, Inc.
 * @link        http://aiwebsystems.com
 */
class Decimal extends FieldTypeAbstract
{
    /**
     * Field type slug
     * @var string
     */
    public $field_type_slug = 'decimal';

    /**
     * Database column type
     * @var bool
     */
    public $db_col_type = false;

    /**
     * Version
     * @var string
     */
    public $version = '1.2';

    /**
     * Custom parameters
     * @var array
     */
    public $custom_parameters = array(
        'total',
        'places'
    );

    /**
     * Author
     * @var array
     */
    public $author = array(
        'name' => 'Ryan Thompson - AI Web Systems, Inc.',
        'url'  => 'http://www.aiwebsystems.com/'
    );

    /**
     * Pre save
     *
     * @return mixed
     */
    public function preSave()
    {
        return preg_replace('/[^0-9.]*/', '', $this->value);
    }

    /**
     * Places (from Laravel's decimal(name, total, PLACES)
     * @return    string
     */
    public function paramPlaces($value = 0)
    {
        return form_input('places', $value);
    }

    /**
     * Total (from Laravel's decimal(name, TOTAL, places)
     * @return    string
     */
    public function paramTotal($value = 0)
    {
        return form_input('total', $value);
    }

    /**
     * Field assignment construct
     * @return void
     */
    public function fieldAssignmentConstruct($schema)
    {
        // Get some variables
        $instance = $this;
        $table    = $this->getStream()->getTableName();

        // Create a decimal column
        $schema->table(
            $table,
            function ($table) use ($instance) {
                $table->decimal(
                    $this->getColumnName(),
                    $instance->getParameter('total', 10),
                    $instance->getParameter('places', 2)
                );
            }
        );
    }
}
