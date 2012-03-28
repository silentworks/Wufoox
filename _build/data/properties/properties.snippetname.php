<?php
/**
 * @package venuex
 */
$properties = array(
    array(
        'name' => 'tpl',
        'desc' => 'extra_name.properties.tpl',
        'type' => 'textfield',
        'options' => '',
        'value' => 'rowTpl',
        'lexicon' => 'extra_name:properties',
    ),
    array(
        'name' => 'sort',
        'desc' => 'extra_name.properties.sort',
        'type' => 'textfield',
        'options' => '',
        'value' => 'id',
        'lexicon' => 'extra_name:properties',
    ),
    array(
        'name' => 'dir',
        'desc' => 'extra_name.properties.dir',
        'type' => 'list',
        'options' => array(
            array('text' => 'extra_name.properties.ascending', 'value' => 'ASC'),
            array('text' => 'extra_name.properties.descending', 'value' => 'DESC'),
        ),
        'value' => 'DESC',
        'lexicon' => 'extra_name:properties',
    ),
    array(
        'name' => 'limit',
        'desc' => 'extra_name.properties.limit',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'extra_name:properties',
    ),
    array(
        'name' => 'offset',
        'desc' => 'extra_name.properties.offset',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'extra_name:properties',
    ),
);
return $properties;
