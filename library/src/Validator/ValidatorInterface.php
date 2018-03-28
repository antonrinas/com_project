<?php

namespace Framework\Validator;


interface ValidatorInterface
{
    /**
     * @return array
     */
    public function getElementsFilters();

    /**
     * @param array $elementsFilters
     *
     * @return ValidatorInterface
     */
    public function setElementsFilters($elementsFilters);

    /**
     * @return array
     */
    public function getFormElements();

    /**
     * @param array $formElements
     * @return ValidatorInterface
     */
    public function setFormElements($formElements);

    /**
     * @return array
     */
    public function getElementsValidators();

    /**
     * @param array $elementsValidators
     * @return ValidatorInterface
     */
    public function setElementsValidators($elementsValidators);

    /**
     * @return array
     */
    public function getElementsErrors();

    /**
     * @param array $elementsErrors
     * @return ValidatorInterface
     */
    public function setElementsErrors($elementsErrors);

    /**
     * @param string $elementName
     * @return bool|mixed
     */
    public function getElementValue($elementName);

    /**
     * @param string $elementName
     * @param string mixed
     *
     * @return ValidatorInterface
     */
    public function setElementValue($elementName, $value);

    /**
     * @param string $elementName
     *
     * @return array|mixed
     */
    public function getElementValidators($elementName);

    /**
     * @return bool
     */
    public function isValid();
}