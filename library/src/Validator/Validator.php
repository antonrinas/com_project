<?php

namespace Framework\Validator;

class Validator implements ValidatorInterface
{
    const ERROR_MESSAGE_DEFAULT = 'Invalid input';
    const ERROR_MESSAGE_NOT_EMPTY = 'This field cannot be empty';
    const ERROR_MESSAGE_STRING_LENGTH = 'Invalid string length';
    const ERROR_MESSAGE_REGEX = 'The value does not match the valid pattern';
    const ERROR_MESSAGE_EMAIL = 'Wrong email format';
    const ERROR_MESSAGE_IDENTICAL = 'Fields values do not match';

    /**
     * @var array
     */
    private $formElements = [];

    /**
     * @var array
     */
    private $elementsValidators = [];

    /**
     * @var array
     */
    private $elementsFilters = [];

    /**
     * @var array
     */
    private $elementsErrors = [];

    /**
     * @return array
     */
    public function getElementsFilters()
    {
        return $this->elementsFilters;
    }

    /**
     * @param array $elementsFilters
     *
     * @return ValidatorInterface
     */
    public function setElementsFilters($elementsFilters)
    {
        $this->elementsFilters = $elementsFilters;
        return $this;
    }

    /**
     * @return array
     */
    public function getFormElements()
    {
        return $this->formElements;
    }

    /**
     * @param array $formElements
     * @return ValidatorInterface
     */
    public function setFormElements($formElements)
    {
        $this->formElements = $formElements;
        return $this;
    }

    /**
     * @return array
     */
    public function getElementsValidators()
    {
        return $this->elementsValidators;
    }

    /**
     * @param array $elementsValidators
     * @return ValidatorInterface
     */
    public function setElementsValidators($elementsValidators)
    {
        $this->elementsValidators = $elementsValidators;
        return $this;
    }

    /**
     * @return array
     */
    public function getElementsErrors()
    {
        return $this->elementsErrors;
    }

    /**
     * @param array $elementsErrors
     * @return ValidatorInterface
     */
    public function setElementsErrors($elementsErrors)
    {
        $this->elementsErrors = $elementsErrors;
        return $this;
    }

    public function __construct($formElements = array(), $elementsValidators = array(), $elementsFilters = array())
    {
        $this->setFormElements($formElements);
        $this->setElementsValidators($elementsValidators);
        $this->setElementsFilters($elementsFilters);
    }

    /**
     * @param string $elementName
     * @return bool|mixed
     */
    public function getElementValue($elementName)
    {
        $elements = $this->getFormElements();
        if (array_key_exists($elementName, $elements)) return $elements[$elementName];
        return false;
    }

    /**
     * @param string $elementName
     * @param string mixed
     *
     * @return ValidatorInterface
     */
    public function setElementValue($elementName, $value)
    {
        $elements = $this->getFormElements();
        if (array_key_exists($elementName, $elements)){
            $elements[$elementName] = $value;
        }
        $this->setFormElements($elements);
        return $this;
    }

    /**
     * @param string $elementName
     *
     * @return array|mixed
     */
    public function getElementValidators($elementName)
    {
        $elements = $this->getFormElements();
        $validators = $this->getElementsValidators();
        if (array_key_exists($elementName, $elements)){
            return $validators[$elementName];
        }
        return array();
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        $this->setElementsErrors(null);
        $validators = $this->getElementsValidators();
        $filters = $this->getElementsFilters();

        if ($filters) {
            $this->filterValues();
        }

        foreach ($validators as $elementName => $validatorsArray){
            foreach ($validatorsArray as $validator){
                $validatorName = $validator['name'];
                $message = '';
                if (array_key_exists('message', $validator)) $message = $validator['message'];
                switch ($validatorName){
                    case 'notEmptyValidator':
                        $this->$validatorName($elementName, $message);
                        break;
                    case 'stringLengthValidator':
                        $this->$validatorName($elementName, $message, $validator['min'], $validator['max']);
                        break;
                    case 'regexValidator':
                        $this->$validatorName($elementName, $validator['regex'], $message);
                        break;
                    case 'emailAddressValidator':
                        $this->$validatorName($elementName, $message);
                        break;
                    case 'identicalValidator':
                        $this->$validatorName($elementName, $validator['compareWith'], $message);
                        break;
                    case 'isEmailServiceExistsValidator':
                        $this->$validatorName($elementName, $message);
                        break;
                    default:
                        break;
                }
            }
        }
        if ($this->getElementsErrors()){
            return false;
        }
        return true;
    }

    /**
     * @param string $elementName
     * @param string $message
     *
     * @return bool
     */
    protected function notEmptyValidator($elementName, $message = '')
    {
        if ($this->getElementValue($elementName)) return true;
        $this->addErrorMessage('empty', $elementName, $message);
        return false;
    }

    /**
     * @param string $elementName
     * @param string $message
     * @param int $min
     * @param int $max
     *
     * @return bool
     */
    protected function stringLengthValidator($elementName, $message = '', $min = 0, $max = 255)
    {
        $valueLength = strlen($this->getElementValue($elementName));
        if (($valueLength >= $min) && ($valueLength <= $max)) return true;
        $this->addErrorMessage('string_length', $elementName, $message);
        return false;
    }

    /**
     * @param string $elementName
     * @param string $pattern
     * @param string $message
     *
     * @return bool
     */
    protected function regexValidator($elementName, $pattern, $message = '')
    {
        $value = $this->getElementValue($elementName);
        if (preg_match($pattern, $value)) return true;
        $this->addErrorMessage('regex', $elementName, $message);
        return false;
    }

    /**
     * @param string $elementName
     * @param string $message
     *
     * @return bool
     */
    protected function emailAddressValidator($elementName, $message = '')
    {
        $value = $this->getElementValue($elementName);
        if (filter_var($value, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        $this->addErrorMessage('email_address', $elementName, $message);
        return false;
    }

    /**
     * @param string $elementName
     * @param string $message
     *
     * @return bool
     */
    protected function isEmailServiceExistsValidator($elementName, $message = '')
    {
        $email = $this->getElementValue($elementName);
        $emailParts = explode("@" , $email);
        $host = end($emailParts);
        if (getmxrr($host, $mxhosts)) {
            return true;
        } else {
            $this->addErrorMessage('is_email_service_exists', $elementName, $message);
            return false;
        }
    }

    /**
     * @param string $elementName1
     * @param string $elementName2
     * @param string $message
     *
     * @return bool
     */
    protected function identicalValidator($elementName1, $elementName2, $message = '')
    {
        $value1 = $this->getElementValue($elementName1);
        $value2 = $this->getElementValue($elementName2);
        if ($value1 === $value2) return true;
        $this->addErrorMessage('identical', $elementName1, $message);
        return false;
    }

    /**
     * @param string $nameSpace
     * @param string $elementName
     * @param string $message
     */
    protected function addErrorMessage($nameSpace = 'default', $elementName, $message = '')
    {
        $errorMessages = $this->getElementsErrors();
        if (!$message){
            $message = self::ERROR_MESSAGE_DEFAULT;
            if ($nameSpace === 'empty') $message = self::ERROR_MESSAGE_NOT_EMPTY;
            if ($nameSpace === 'string_length') $message = self::ERROR_MESSAGE_STRING_LENGTH;
            if ($nameSpace === 'regex') $message = self::ERROR_MESSAGE_REGEX;
            if ($nameSpace === 'email_address') $message = self::ERROR_MESSAGE_EMAIL;
            if ($nameSpace === 'identical') $message = self::ERROR_MESSAGE_IDENTICAL;
        }
        $errorMessages[$elementName][] = $message;

        $this->setElementsErrors($errorMessages);
    }

    /**
     * @return void
     */
    protected function filterValues()
    {
        $filters = $this->getElementsFilters();
        foreach ($filters as $elementName => $filtersArray){
            foreach ($filtersArray as $filterName)
                $this->$filterName($elementName);
        }
    }

    /**
     * @return void
     */
    protected function trimFilter($elementName)
    {
        $value = $this->getElementValue($elementName);
        $value = trim($value);
        $this->setElementValue($elementName, $value);
    }

    /**
     * @return void
     */
    protected function stripSlashesFilter($elementName)
    {
        $value = $this->getElementValue($elementName);
        $value = stripslashes($value);
        $this->setElementValue($elementName, $value);
    }

    /**
     * @return void
     */
    protected function htmlSpecialCharsFilter($elementName)
    {
        $value = $this->getElementValue($elementName);
        $value = htmlspecialchars($value, ENT_NOQUOTES, 'UTF-8');
        $this->setElementValue($elementName, $value);
    }

    /**
     * @return void
     */
    protected function stripTags($elementName)
    {
        $value = $this->getElementValue($elementName);
        $value = strip_tags($value);
        $this->setElementValue($elementName, $value);
    }
}