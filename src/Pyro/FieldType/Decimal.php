<?php namespace Pyro\FieldType;

use Pyro\Module\Streams_core\AbstractFieldType;

/**
 * Decimal Field Type
 *
 * @author        Ryan Thompson - AI Web Systems, Inc.
 * @copyright    Copyright (c) 208 - 2012, AI Web Systems, Inc.
 * @link        http://aiwebsystems.com
 */
class Decimal extends AbstractFieldType
{
    public $field_type_name = 'Decimal';

    public $field_type_slug = 'decimal';
    
    public $db_col_type = 'float';

    public $version = '1.2';

    public $custom_parameters = array(
        'decimal_places',
        'default_value',
        'min_value',
        'max_value'
        );

    public $author = array(
        'name'=>'Ryan Thompson - AI Web Systems, Inc.',
        'url'=>'http://aiwebsystems.com'
        );
    
    /**
     * Process before saving to database
     *
     * @access    public
     * @param    float
     * @param    object
     * @return    string
     */
    public function preSave()
    {
        // Get ceiling and floot
        $max_value = $this->getParameter('max_value', false);
        $min_value = $this->getParameter('min_value', false);

        // To High?
        if ($max_value and $max_value > 0 and $this->value > $max_value)
        {
            return $max_value;
        }

        // To Low?
        if ($min_value and $min_value > 0 and $this->value < $min_value)
        {
            return $min_value;
        }

        return round($this->value, $this->getParameter('decimal_places', 0));
    }

    /**
     * Process before outputting
     *
     * @access    public
     * @param    float
     * @param    array
     * @return    float
     */
    public function stringOutput()
    {
        return round($this->value, $this->getParameter('decimal_places', 0));
    }

    /**
     * Output the form input
     *
     * @access    public
     * @param    array
     * @param    int
     * @param    object
     * @return    string
     */
    public function formInput()
    {
        $options['name']     = $this->form_slug;
        $options['id']        = $this->form_slug;
        $options['value']    = $this->value;
        $options['class']    = 'form-control';
        
        return form_input($options);
    }

    /**
     * How many decimals do you want to maintain?
     *
     * @return    string
     */
    public function paramDecimalPlaces($value = 0)
    {
        return form_input('decimal_places', $value);
    }

    /**
     * Min value?
     *
     * @return    string
     */
    public function paramMinValue($value = null)
    {
        return form_input('min_value', $value);
    }

    /**
     * Max value?
     *
     * @return    string
     */
    public function paramMaxValue($value = null)
    {
        return form_input('max_value', $value);
    }
}
