<?php

use PHPUnit\Framework\TestCase;
use Framework\Validator\Validator;
use Framework\Validator\ValidatorInterface;

class ValidatorTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: Validator tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $validator = new Validator();
        $this->assertInstanceOf(
            Validator::class,
            $validator
        );

        return $validator;
    }

    /**
     * @param ValidatorInterface $validator
     * @depends clone testCanBeCreated
     */
    public function testCanSetGetData($validator)
    {
        echo PHP_EOL . "    ---- Can set/get data test" . PHP_EOL;
        $validator->setFormElements(['elements']);
        $this->assertSame(['elements'], $validator->getFormElements());
        $validator->setElementsErrors(['errors']);
        $this->assertSame(['errors'], $validator->getElementsErrors());
        $validator->setElementsFilters(['filters']);
        $this->assertSame(['filters'], $validator->getElementsFilters());
        $validator->setElementsValidators(['validators']);
        $this->assertSame(['validators'], $validator->getElementsValidators());
        $validator->setFormElements(['name' => '']);
        $validator->setElementValue('name', 'value');
        $this->assertSame('value', $validator->getElementValue('name'));
        $validator->setFormElements(['name' => '']);
        $this->assertNotSame('value', $validator->getElementValue('name'));
    }

    /**
     * @param ValidatorInterface $validator
     * @depends clone testCanBeCreated
     */
    public function testNotEmptyValidator($validator)
    {
        echo PHP_EOL . "    ---- notEmptyValidator test" . PHP_EOL;
        $validator->setFormElements(['data' => '']);
        $validator->setElementsFilters([]);
        $validator->setElementsValidators([
            'data' => [
                [
                    'name' => 'notEmptyValidator',
                    'message' => 'notEmptyValidator message'
                ],
            ]
        ]);
        $this->assertFalse($validator->isValid());
        $this->assertSame(['data' => ['notEmptyValidator message']], $validator->getElementsErrors());
        $validator->setFormElements(['data' => 'data']);
        $this->assertTrue($validator->isValid());
    }

    /**
     * @param ValidatorInterface $validator
     * @depends clone testCanBeCreated
     */
    public function testStringLengthValidator($validator)
    {
        echo PHP_EOL . "    ---- stringLengthValidator test" . PHP_EOL;
        $validator->setFormElements(['data' => 'data']);
        $validator->setElementsFilters([]);
        $validator->setElementsValidators([
            'data' => [
                [
                    'name' => 'stringLengthValidator',
                    'min' => 0,
                    'max' => 1,
                    'message' => 'stringLengthValidator message'
                ],
            ]
        ]);
        $this->assertFalse($validator->isValid());
        $this->assertSame(['data' => ['stringLengthValidator message']], $validator->getElementsErrors());
        $validator->setFormElements(['data' => 'd']);
        $this->assertTrue($validator->isValid());
    }

    /**
     * @param ValidatorInterface $validator
     * @depends clone testCanBeCreated
     */
    public function testRegexValidator($validator)
    {
        echo PHP_EOL . "    ---- regexValidator test" . PHP_EOL;
        $validator->setFormElements(['data' => 'data']);
        $validator->setElementsFilters([]);
        $validator->setElementsValidators([
            'data' => [
                [
                    'name' => 'regexValidator',
                    'message' => 'regexValidator message',
                    'regex' => '/^(1|2)*$/'
                ],
            ]
        ]);
        $this->assertFalse($validator->isValid());
        $this->assertSame(['data' => ['regexValidator message']], $validator->getElementsErrors());
        $validator->setFormElements(['data' => '2']);
        $this->assertTrue($validator->isValid());
    }

    /**
     * @param ValidatorInterface $validator
     * @depends clone testCanBeCreated
     */
    public function testEmailAddressValidator($validator)
    {
        echo PHP_EOL . "    ---- emailAddressValidator test" . PHP_EOL;
        $validator->setFormElements(['data' => 'test@gmail.com']);
        $validator->setElementsFilters([]);
        $validator->setElementsValidators([
            'data' => [
                [
                    'name' => 'emailAddressValidator',
                    'message' => 'emailAddressValidator message'
                ],
            ]
        ]);
        $this->assertTrue($validator->isValid());
        $validator->setFormElements(['data' => '2']);
        $this->assertFalse($validator->isValid());
        $this->assertSame(['data' => ['emailAddressValidator message']], $validator->getElementsErrors());
    }

    /**
     * @param ValidatorInterface $validator
     * @depends clone testCanBeCreated
     */
    public function testIsEmailServiceExistsValidator($validator)
    {
        echo PHP_EOL . "    ---- isEmailServiceExistsValidator test" . PHP_EOL;
        $validator->setFormElements(['data' => 'test@gmail.com']);
        $validator->setElementsFilters([]);
        $validator->setElementsValidators([
            'data' => [
                [
                    'name' => 'isEmailServiceExistsValidator',
                    'message' => 'isEmailServiceExistsValidator message'
                ],
            ]
        ]);
        $this->assertTrue($validator->isValid());
        $validator->setFormElements(['data' => '2']);
        $this->assertFalse($validator->isValid());
        $this->assertSame(['data' => ['isEmailServiceExistsValidator message']], $validator->getElementsErrors());
    }

    /**
     * @param ValidatorInterface $validator
     * @depends clone testCanBeCreated
     */
    public function testIdenticalValidator($validator)
    {
        echo PHP_EOL . "    ---- identicalValidator test" . PHP_EOL;
        $validator->setFormElements(['param1' => 'value1', 'param2' => 'value1']);
        $validator->setElementsFilters([]);
        $validator->setElementsValidators([
            'param1' => [
                [
                    'name' => 'identicalValidator',
                    'message' => 'identicalValidator message',
                    'compareWith' => 'param2',
                ],
            ]
        ]);
        $this->assertTrue($validator->isValid());
        $validator->setFormElements(['param1' => 'value1', 'param2' => 'value2']);
        $this->assertFalse($validator->isValid());
        $this->assertSame(['param1' => ['identicalValidator message']], $validator->getElementsErrors());
    }
}